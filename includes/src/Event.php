<?php
/**
 * Docket Cache.
 *
 * @author  Nawawi Jamili
 * @license MIT
 *
 * @see    https://github.com/nawawi/docket-cache
 */

namespace Nawawi\DocketCache;

\defined('ABSPATH') || exit;

class Event
{
    private $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * register.
     */
    public function register()
    {
        add_filter(
            'cron_schedules',
            function ($schedules) {
                $schedules = [
                    'halfhour' => [
                        'interval' => 30 * MINUTE_IN_SECONDS,
                        'display' => esc_html__('Every 30 minutes', 'docket-cache'),
                    ],
                    'monthly' => [
                        'interval' => MONTH_IN_SECONDS,
                        'display' => esc_html__('Once Monthly', 'docket-cache'),
                    ],
                ];

                return $schedules;
            }
        );

        add_action(
            'plugin_loaded',
            function () {
                // gc
                if ($this->plugin->constans()->is_true('DOCKET_CACHE_GC')) {
                    add_action('docket_cache_gc', [$this, 'garbage_collector']);

                    if (!wp_next_scheduled('docket_cache_gc')) {
                        wp_schedule_event(time(), 'halfhour', 'docket_cache_gc');
                    }
                } else {
                    if (wp_get_schedule('docket_cache_gc')) {
                        wp_clear_scheduled_hook('docket_cache_gc');
                    }
                }

                // optimize db
                $cronoptmzdb = $this->plugin->constans()->value('DOCKET_CACHE_CRONOPTMZDB');
                if (!empty($cronoptmzdb) && 'never' !== $cronoptmzdb) {
                    add_action('docket_cache_optimizedb', [$this, 'optimizedb']);

                    $recurrence = 'weekly';
                    switch ($cronoptmzdb) {
                        case 'daily':
                            $recurrence = 'daily';
                            break;
                        case 'weekly':
                            $recurrence = 'weekly';
                            break;
                        case 'monthly':
                            $recurrence = 'monthly';
                            break;
                    }

                    if (!wp_next_scheduled('docket_cache_optimizedb')) {
                        wp_schedule_event(time(), $recurrence, 'docket_cache_optimizedb');
                    }
                } else {
                    if (wp_get_schedule('docket_cache_optimizedb')) {
                        wp_clear_scheduled_hook('docket_cache_optimizedb');
                    }
                }

                // monitor
                add_action('docket_cache_monitor', [$this, 'monitor']);
                if (!wp_next_scheduled('docket_cache_monitor')) {
                    wp_schedule_event(time(), 'hourly', 'docket_cache_monitor');
                }
            }
        );

        add_filter(
            'heartbeat_send',
            function ($response, $screen_id) {
                if (is_admin() && is_user_logged_in() && current_user_can('manage_options')) {
                    $locked = wp_cache_get('heartbeat_tick', 'docketcache-event');
                    if (!empty($locked) && time() > (int) $locked) {
                        do_action('docket-cache/countcachesize');
                    }
                    wp_cache_set('heartbeat_tick', time() + 90, 'docketcache-event');
                }

                return $response;
            },
            PHP_INT_MAX,
            2
        );
    }

    /**
     * unregister.
     */
    public function unregister()
    {
        foreach (['docket_cache_gc', 'docket_cache_optimizedb', 'docket_cache_monitor'] as $hx) {
            wp_clear_scheduled_hook($hx);
        }
    }

    /**
     * monitor.
     */
    public function monitor()
    {
        $this->clear_unknown_cron();
        $this->delete_expired_transients_db();
        do_action('docket-cache/suspend_wp_options_autoload');
        do_action('docket-cache/countcachesize');
    }

    /**
     * garbage_collector.
     */
    public function garbage_collector()
    {
        if ($this->plugin->is_docketcachedir($this->plugin->cache_path)) {
            clearstatcache();
            foreach ($this->plugin->scanfiles($this->plugin->cache_path) as $object) {
                $fx = $object->getPathName();

                if (!$object->isFile() || 'file' !== $object->getType() || !$this->plugin->is_php($fx)) {
                    continue;
                }

                $fn = $object->getFileName();
                $fs = $object->getSize();
                $fm = time() + 120;

                if ($fm >= filemtime($fx) && (0 === $fs || 'dump_' === substr($fn, 0, 5))) {
                    $this->plugin->unlink($fx, true);
                    continue;
                }

                $data = $this->plugin->cache_get($fx);
                if (false !== $data && !empty($data['timeout']) && $fm >= (int) $data['timeout']) {
                    $this->plugin->unlink($fx, false);
                    unset($data);
                    continue;
                }
                unset($data);
            }
        }
        $this->plugin->dropino()->delay_expire();
    }

    /**
     * optimizedb.
     */
    public function optimizedb()
    {
        $wpdb = $this->plugin->safe_wpdb();
        if (!$wpdb) {
            return false;
        }

        $suppress = $wpdb->suppress_errors(true);
        $this->delete_expired_transients_db();

        $dbname = $wpdb->dbname;
        $tables = $wpdb->get_results('SHOW TABLES FROM '.$dbname, ARRAY_A);
        if (!empty($tables) && \is_array($tables)) {
            foreach ($tables as $table) {
                $tbl = $table['Tables_in_'.$dbname];
                $wpdb->query('OPTIMIZE TABLE `'.$tbl.'`');
            }
        }

        $wpdb->suppress_errors($suppress);

        return true;
    }

    /**
     * delete_expired_transients_db.
     */
    public function delete_expired_transients_db()
    {
        if (!wp_using_ext_object_cache()) {
            return false;
        }

        $wpdb = $this->plugin->safe_wpdb();
        if (!$wpdb) {
            return false;
        }

        // delete expired transient in db
        // https://developer.wordpress.org/reference/functions/delete_expired_transients/
        delete_expired_transients(true);

        return true;
    }

    /**
     * clear_unknown_cron.
     */
    public function clear_unknown_cron()
    {
        if (!\function_exists('_get_cron_array')) {
            return;
        }
        $crons = _get_cron_array();
        if (!empty($crons) && \is_array($crons)) {
            foreach ($crons as $time => $cron) {
                foreach ($cron as $hook => $dings) {
                    if (!has_action($hook)) {
                        wp_clear_scheduled_hook($hook);
                    }
                }
            }
        }
        unset($crons);
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit71169967e8f502f7da209e4236957996
{
    public static $files = array (
        '15e84a079fbc1a89efdbcf97033b2669' => __DIR__ . '/..' . '/symfony/polyfill-php80/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'Nawawi\\Symfony\\Polyfill\\Php80\\' => 30,
            'Nawawi\\Symfony\\Component\\VarExporter\\' => 37,
            'Nawawi\\DocketCache\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Nawawi\\Symfony\\Polyfill\\Php80\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php80',
        ),
        'Nawawi\\Symfony\\Component\\VarExporter\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/var-exporter',
        ),
        'Nawawi\\DocketCache\\' => 
        array (
            0 => __DIR__ . '/../../..' . '/includes/src',
        ),
    );

    public static $classMap = array (
        'Nawawi\\DocketCache\\AdvancedPost' => __DIR__ . '/../../..' . '/includes/src/AdvancedPost.php',
        'Nawawi\\DocketCache\\Bepart' => __DIR__ . '/../../..' . '/includes/src/Bepart.php',
        'Nawawi\\DocketCache\\Canopt' => __DIR__ . '/../../..' . '/includes/src/Canopt.php',
        'Nawawi\\DocketCache\\Command' => __DIR__ . '/../../..' . '/includes/src/Command.php',
        'Nawawi\\DocketCache\\Constans' => __DIR__ . '/../../..' . '/includes/src/Constans.php',
        'Nawawi\\DocketCache\\Crawler' => __DIR__ . '/../../..' . '/includes/src/Crawler.php',
        'Nawawi\\DocketCache\\Dropinoc' => __DIR__ . '/../../..' . '/includes/src/Dropino.php',
        'Nawawi\\DocketCache\\Filesystem' => __DIR__ . '/../../..' . '/includes/src/Filesystem.php',
        'Nawawi\\DocketCache\\MoCache' => __DIR__ . '/../../..' . '/includes/src/MoCache.php',
        'Nawawi\\DocketCache\\Plugin' => __DIR__ . '/../../..' . '/includes/src/Plugin.php',
        'Nawawi\\DocketCache\\PrivateRepo' => __DIR__ . '/../../..' . '/includes/src/PrivateRepo.php',
        'Nawawi\\DocketCache\\TermCount' => __DIR__ . '/../../..' . '/includes/src/TermCount.php',
        'Nawawi\\DocketCache\\Tweaks' => __DIR__ . '/../../..' . '/includes/src/Tweaks.php',
        'Nawawi\\DocketCache\\View' => __DIR__ . '/../../..' . '/includes/src/View.php',
        'Nawawi\\Symfony\\Component\\VarExporter\\Exception\\ClassNotFoundException' => __DIR__ . '/..' . '/symfony/var-exporter/Exception/ClassNotFoundException.php',
        'Nawawi\\Symfony\\Component\\VarExporter\\Exception\\ExceptionInterface' => __DIR__ . '/..' . '/symfony/var-exporter/Exception/ExceptionInterface.php',
        'Nawawi\\Symfony\\Component\\VarExporter\\Exception\\NotInstantiableTypeException' => __DIR__ . '/..' . '/symfony/var-exporter/Exception/NotInstantiableTypeException.php',
        'Nawawi\\Symfony\\Component\\VarExporter\\Instantiator' => __DIR__ . '/..' . '/symfony/var-exporter/Instantiator.php',
        'Nawawi\\Symfony\\Component\\VarExporter\\Internal\\Exporter' => __DIR__ . '/..' . '/symfony/var-exporter/Internal/Exporter.php',
        'Nawawi\\Symfony\\Component\\VarExporter\\Internal\\Hydrator' => __DIR__ . '/..' . '/symfony/var-exporter/Internal/Hydrator.php',
        'Nawawi\\Symfony\\Component\\VarExporter\\Internal\\Reference' => __DIR__ . '/..' . '/symfony/var-exporter/Internal/Reference.php',
        'Nawawi\\Symfony\\Component\\VarExporter\\Internal\\Registry' => __DIR__ . '/..' . '/symfony/var-exporter/Internal/Registry.php',
        'Nawawi\\Symfony\\Component\\VarExporter\\Internal\\Values' => __DIR__ . '/..' . '/symfony/var-exporter/Internal/Values.php',
        'Nawawi\\Symfony\\Component\\VarExporter\\VarExporter' => __DIR__ . '/..' . '/symfony/var-exporter/VarExporter.php',
        'Nawawi\\Symfony\\Polyfill\\Php80\\Php80' => __DIR__ . '/..' . '/symfony/polyfill-php80/Php80.php',
        'Stringable' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Stringable.php',
        'UnhandledMatchError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/UnhandledMatchError.php',
        'ValueError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/ValueError.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit71169967e8f502f7da209e4236957996::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit71169967e8f502f7da209e4236957996::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit71169967e8f502f7da209e4236957996::$classMap;

        }, null, ClassLoader::class);
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8cdd1f48cac6c5dbf03ee44b156e5758
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Macmini\\Newspaper\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Macmini\\Newspaper\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8cdd1f48cac6c5dbf03ee44b156e5758::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8cdd1f48cac6c5dbf03ee44b156e5758::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8cdd1f48cac6c5dbf03ee44b156e5758::$classMap;

        }, null, ClassLoader::class);
    }
}
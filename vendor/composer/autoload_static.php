<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit236c586daefab96056c4426dfccc3fad
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit236c586daefab96056c4426dfccc3fad::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit236c586daefab96056c4426dfccc3fad::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit236c586daefab96056c4426dfccc3fad::$classMap;

        }, null, ClassLoader::class);
    }
}

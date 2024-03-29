<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit59b957bc2424b3013dfa839643b47898
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Lib\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Lib\\' => 
        array (
            0 => __DIR__ . '/../..' . '/libs',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit59b957bc2424b3013dfa839643b47898::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit59b957bc2424b3013dfa839643b47898::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit59b957bc2424b3013dfa839643b47898::$classMap;

        }, null, ClassLoader::class);
    }
}

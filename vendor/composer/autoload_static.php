<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3c558e521981c4ff150143438a1e270d
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Predis\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Predis\\' => 
        array (
            0 => __DIR__ . '/..' . '/predis/predis/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3c558e521981c4ff150143438a1e270d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3c558e521981c4ff150143438a1e270d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3c558e521981c4ff150143438a1e270d::$classMap;

        }, null, ClassLoader::class);
    }
}

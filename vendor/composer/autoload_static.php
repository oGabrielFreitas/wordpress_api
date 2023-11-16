<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2bd3b1803a861e74380786f65ee4828a
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'src\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'src\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'FPDF' => __DIR__ . '/..' . '/setasign/fpdf/fpdf.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2bd3b1803a861e74380786f65ee4828a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2bd3b1803a861e74380786f65ee4828a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2bd3b1803a861e74380786f65ee4828a::$classMap;

        }, null, ClassLoader::class);
    }
}
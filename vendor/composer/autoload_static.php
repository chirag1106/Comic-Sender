<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitec1a7f06180ec99a5ee5a79d6cfcbd4b
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitec1a7f06180ec99a5ee5a79d6cfcbd4b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitec1a7f06180ec99a5ee5a79d6cfcbd4b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitec1a7f06180ec99a5ee5a79d6cfcbd4b::$classMap;

        }, null, ClassLoader::class);
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbe6ec929c9b43ed5d7de8865a515bd7b
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

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbe6ec929c9b43ed5d7de8865a515bd7b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbe6ec929c9b43ed5d7de8865a515bd7b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

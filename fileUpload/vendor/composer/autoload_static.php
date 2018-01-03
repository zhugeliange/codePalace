<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit530aafb765b2bdc4efcdbdb9acd35719
{
    public static $files = array (
        '841780ea2e1d6545ea3a253239d59c05' => __DIR__ . '/..' . '/qiniu/php-sdk/src/Qiniu/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'Q' => 
        array (
            'Qiniu\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Qiniu\\' => 
        array (
            0 => __DIR__ . '/..' . '/qiniu/php-sdk/src/Qiniu',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit530aafb765b2bdc4efcdbdb9acd35719::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit530aafb765b2bdc4efcdbdb9acd35719::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

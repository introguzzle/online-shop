<?php


namespace core;

use Closure;
use reflector\Resolver;

class Autoloader
{

    public static function register(): void
    {
        spl_autoload_register(self::getResolver());
    }

    private static function getResolver(): Closure
    {
        return static function (string $class): bool {
            $path = Resolver::getPath($class);

            if (file_exists($path)) {
                require_once $path;
                return true;
            }

            return false;
        };
    }
}
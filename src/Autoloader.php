<?php


use reflector\Resolver;

class Autoloader {

    public static function register(): void {
        spl_autoload_register(self::getResolver());
    }

    private static function getResolver(): Closure {
        return static function (string $class): bool {
            $path = Resolver::getPath($class);

            file_put_contents("s.s", $path);

            if (file_exists($path)) {
                require_once $path;
                return true;
            }

            return false;
        };
    }
}
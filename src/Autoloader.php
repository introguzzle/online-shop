<?php

class Autoloader {

    public static function register(): void {
        spl_autoload_register(Autoloader::getAutoloader());
    }

    private static function getAutoloader(): Closure {
        return function (string $class): bool {
            $inverse = function(string $class): string {
                return str_replace("\\", DIRECTORY_SEPARATOR, $class);
            };

            $path = __DIR__
                . '/'
                . $inverse($class)
                . ".php";

            if (file_exists($path)) {
                require_once $path;
                return true;
            }

            return false;
        };
    }
}
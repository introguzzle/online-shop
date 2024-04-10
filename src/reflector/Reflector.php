<?php

namespace reflector;

class Reflector {

}

function ref(string $class): string {
    $inverse = function(string $class): string {
        return str_replace("\\", DIRECTORY_SEPARATOR, $class);
    };

    $dn = function(string $path): string {
        return str_replace(__NAMESPACE__ . "/", "", $path);
    };


    return $dn(
        __DIR__
        . '/'
        . $inverse($class)
        . ".php"
    );
}




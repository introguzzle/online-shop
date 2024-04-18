<?php

namespace util;

final class NamingConventions {

    public static function snakeToCamel(string $snake, string $score = "_"): string
    {
        return lcfirst(str_replace($score, '', ucwords($snake, $score)));
    }

    public static function camelToSnake(string $camel, string $score = "_"): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', "$score" . "$0", $camel));
    }
}
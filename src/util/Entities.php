<?php

namespace util;

final class Entities {
    public static function getGetterByField(string $field): string
    {
        $f = self::snakeToCamel($field);
        $f[0] = strtoupper($f[0]);
        return "get" . $f;
    }

    public static function getSetterByField(string $field): string
    {
        $f = self::snakeToCamel($field);
        $f[0] = strtoupper($f[0]);
        return "set" . $f;
    }

    public static function snakeToCamel(string $snake): string
    {
        return lcfirst(str_replace('_', '', ucwords($snake, '_')));
    }

    public static function camelToSnake(string $camel): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $camel));
    }
}
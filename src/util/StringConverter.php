<?php

namespace util;

use ReflectionClass;

final class StringConverter
{
    private const string TAB = "    ";
    public static function toString(object $object): string
    {
        $reflection = new ReflectionClass($object);

        $class = $reflection->getShortName();
        $properties = $reflection->getProperties();

        $result = $class . "[\n";

        foreach ($properties as $property) {
            $name  = $property->getName();
            $value = $property->getValue($object);

            $result .= self::TAB . "$name == $value \n";
        }

        $result .= "]";

        return $result;
    }
}
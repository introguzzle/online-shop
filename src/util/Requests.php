<?php

namespace util;

use dto\DTO;
use http\Exception\RuntimeException;
use ReflectionClass;
use ReflectionException;
use request\Request;

class Requests
{
    public static function toDTO(Request $request, string $class): ?DTO
    {
        try {
            $dtoReflection = new ReflectionClass($class);
        } catch (ReflectionException) {
            return null;
        }

        $requestReflection = new ReflectionClass($request);

        $getters = array_filter($requestReflection->getMethods(), function ($method) {
            return str_starts_with($method->getName(), "get");
        });

        $params = [];

        foreach ($dtoReflection->getConstructor()->getParameters() as $param) {
            $getterName = "get" . ucfirst($param->getName());
            $getter = array_values(array_filter($getters, function ($method) use ($getterName) {
                return $method->getName() === $getterName;
            }));

            $params[] = $getter[0]->invoke($request);
        }

        try {
            return $dtoReflection->newInstanceArgs($params);
        } catch (ReflectionException) {
            return null;
        }
    }
}
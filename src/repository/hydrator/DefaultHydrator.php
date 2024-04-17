<?php

namespace repository\hydrator;

use entity\Entity;
use Exception;
use http\Exception\RuntimeException;
use ReflectionClass;
use Throwable;
use util\Entities;

class DefaultHydrator implements Hydrator
{
    public function __construct()
    {

    }

    public function hydrate(string $entityClass, array $data): Entity
    {
        $columns = $this->extractColumns($data);

        try {
            $reflectionClass = new ReflectionClass($entityClass);

            $constructor = $reflectionClass->getMethod('__construct');
            $parameters = $constructor->getParameters();

            $values = [];
            foreach ($parameters as $parameter) {
                $snake = Entities::camelToSnake($parameter->getName());

                if (in_array($snake, $columns))
                    $values[] = $data[$snake];
            }

            return $reflectionClass->newInstanceArgs($values);
        } catch (Throwable) {
            throw new Exception("Failed to hydrate $entityClass");
        }
    }

    public function extract(Entity $entity): array
    {
        $reflectionClass = new ReflectionClass($entity);
        $properties = $reflectionClass->getProperties();

        $data = [];

        foreach ($properties as $property) {
            $propertyName = $property->getName();

            $snake = Entities::camelToSnake($propertyName);
            $data[$snake] = $property->getValue($entity);
        }

        return $data;
    }

    private function extractColumns(array $data): array {
        $columns = [];

        $filtered = array_filter($data, function($key) {
            return !is_int($key);
        }, ARRAY_FILTER_USE_KEY);

        foreach ($filtered as $key => $value) {
            $columns[] = $key;
        }

        return $columns;
    }
}
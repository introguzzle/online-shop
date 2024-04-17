<?php

namespace core\container;

class DIContainer implements Container
{
    private array $instances = [];

    public function __construct(array ...$arrays)
    {
        foreach ($arrays as $instances)
            $this->append($instances);
    }

    public function set(string $class, callable $callback): void
    {
        $this->instances[$class] = $callback;
    }

    public function get(string $class): object
    {
        if ($this->has($class)) {
            $callback = $this->instances[$class];

            return $callback($this);
        }

        return new $class();
    }

    public function has(string $class): bool
    {
        return isset($this->instances[$class]);
    }

    public function append(array $other): void
    {
        $this->instances = array_merge($this->instances, $other);
    }
}
<?php

namespace core\container;

interface Container {
    public function set(string $class, callable $callback): void;
    public function get(string $class);
    public function has(string $class): bool;
}
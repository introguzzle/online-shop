<?php

namespace reflector;

interface Container {
    public function set(string $class, callable $callback);
    public function get(string $class);
    public function has(string $class);
}
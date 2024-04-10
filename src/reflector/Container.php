<?php

namespace reflector;

interface Container {
    public function get($id);
    public function has($id);
}
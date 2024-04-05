<?php

namespace controller;

use request\Request;

abstract class Controller {
    public abstract function get(): void;

    public abstract function post(): void;
}
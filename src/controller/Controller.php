<?php

namespace controller;

use request\Request;
use view\Renderer;

abstract class Controller
{

    protected Renderer $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }
}
<?php

namespace controller;

use service\SessionAuthenticationService;
use view\Renderer;

class HomeController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function get(): void {
        require_once $this->renderer->render("home.phtml", true);
    }

    public function post(): void {

    }
}
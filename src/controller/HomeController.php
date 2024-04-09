<?php

namespace controller;

use service\SessionAuthenticationService;
use view\Renderer;

class HomeController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function view(): void {
        require_once $this->renderer->render("home.phtml", "Home");
    }

    public function post(): void {

    }
}
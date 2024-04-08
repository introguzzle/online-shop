<?php

namespace controller;

class ProfileController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function get(): void {
        require_once $this->renderer->render("profile.phtml", true);
    }

    public function post(): void {

    }
}
<?php

namespace controller;

use service\RegistrationService;

class RegistrationController extends Controller {

    private RegistrationService $service;

    public function __construct() {
        parent::__construct();
        $this->service = new RegistrationService();
    }

    public function view(): void {
        require_once $this->renderer->render("registration.phtml");
    }

    public function post(): void {
        $result = $this->service->proceed();

        if (gettype($result) === "boolean") {
            require_once $this->renderer->render("login.phtml");
        } else {
            $errors = $result;
            require_once $this->renderer->render("registration.phtml");
        }
    }
}
<?php

namespace controller;

use service\RegistrationService;

class RegistrationController extends Controller {

    private RegistrationService $service;
    private static string $SERVICE = "service\RegistrationService";

    public function __construct() {
        $this->service = new self::$SERVICE;
    }

    public function get(): void {
        require_once "./../view/registration.phtml";
    }

    public function post(): void {
        $result = $this->service->proceed();

        if (gettype($result) === "boolean") {
            require_once "./../view/login.phtml";
        } else {
            $errors = $result;
            require_once "./../view/registration.phtml";
        }
    }
}
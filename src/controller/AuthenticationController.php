<?php

namespace controller;

use dto\User;
use service\AuthenticationService;
use service\LoginService;
use service\SessionAuthenticationService;
use view\Renderer;

class AuthenticationController extends Controller {

    private LoginService $loginService;

    public function __construct() {
        parent::__construct();
        $this->loginService = new LoginService();
    }

    public function get(): void {
        require_once $this->renderer->render("login.phtml");
    }

    public function login(): void {
        $result = $this->loginService->proceed();

        if (gettype($result) === "boolean") {
            require_once $this->renderer->render("home.phtml");
        } else {
            $errors = $result;
            require_once $this->renderer->render("login.phtml");
        }
    }

    public function logout(): void {
        $this->loginService->logout();
        header("Location: /login");
    }
}
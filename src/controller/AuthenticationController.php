<?php

namespace controller;

use dto\User;
use reflector\Resolver;
use repository\UserRepository;
use service\LoginService;

class AuthenticationController extends Controller {

    public static $routes = ["/login" => ["GET", "login"]];

    private LoginService $loginService;

    public function __construct()
    {
        parent::__construct();
        $this->loginService = new LoginService();
    }

    public function view(): void
    {
        require_once $this->renderer->render("login.phtml", "Login");
    }

    public function login(): void
    {
        $result = $this->loginService->proceed();

        if (gettype($result) === "boolean") {
            require_once $this->renderer->render("home.phtml", "Home");
        } else {
            $errors = $result;
            require_once $this->renderer->render("login.phtml", "Login");
        }
    }

    public function logout(): void
    {
        $this->loginService->logout();
        header("Location: /login");
    }
}
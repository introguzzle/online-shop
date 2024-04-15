<?php

namespace controller;

use dto\LoginForm;
use request\LoginRequest;
use service\LoginService;

class AuthenticationController extends Controller
{

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
        $request = $this->acquireLoginRequest();
        $errors = $this->loginService->processAuthentication(new LoginForm(
            $request->getEmail(),
            $request->getPassword()
        ));

        if ($errors->hasNone()) {
            header("Location: /home");
        } else {
            require_once $this->renderer->render("login.phtml", "Login");
        }
    }

    public function logout(): void
    {
        $this->loginService->logout();
        header("Location: /home");
    }

    private function acquireLoginRequest(): LoginRequest
    {
        $email = $_REQUEST["email"] ?? "";
        $password = $_REQUEST["psw"] ?? "";

        if (isset($_REQUEST["remember"]))
            $remember = "0";
        else
            $remember = "1";

        return new LoginRequest($email, $password, $remember);
    }
}
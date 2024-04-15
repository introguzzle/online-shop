<?php

namespace controller;

use dto\RegistrationForm;
use request\RegistrationRequest;
use service\RegistrationService;

class RegistrationController extends Controller
{

    private RegistrationService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new RegistrationService();
    }

    public function view(): void
    {
        require_once $this->renderer->render("registration.phtml");
    }

    public function register(): void
    {
        $request = $this->acquireRegistrationRequest();

        $errors = $this->service->processRegistration(new RegistrationForm(
            $request->getName(),
            $request->getEmail(),
            $request->getPassword(),
            $request->getPasswordRepeat()
        ));

        if ($errors->hasAny()) {
            require_once $this->renderer->render("registration.phtml");
        } else {
            header("Location: /login");
        }
    }

    public function acquireRegistrationRequest(): ?RegistrationRequest
    {
        $name = $_REQUEST["name"];
        $email = $_REQUEST["email"];
        $password = $_REQUEST["psw"];
        $passwordRepeat = $_REQUEST["psw-repeat"];

        return new RegistrationRequest($name, $email, $password, $passwordRepeat);
    }
}
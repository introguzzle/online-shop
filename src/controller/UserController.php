<?php

namespace controller;

use dto\Errors;
use dto\LoginForm;
use dto\RegistrationForm;
use entity\Cart;
use entity\Profile;
use entity\User;
use repository\CartRepository;
use repository\ProfileRepository;
use repository\UserRepository;
use request\LoginRequest;
use request\RegistrationRequest;

class UserController extends Controller
{
    private UserRepository $userRepository;
    private ProfileRepository $profileRepository;
    private CartRepository $cartRepository;

    public function __construct()
    {
        parent::__construct();

        $this->userRepository = new UserRepository();
        $this->profileRepository = new ProfileRepository();
        $this->cartRepository = new CartRepository();
    }

    public function loginView(): void
    {
        require_once $this->renderer->render("login.phtml", "Login");
    }

    public function registrationView(): void
    {
        require_once $this->renderer->render("registration.phtml", "Registration");
    }

    public function login(): void
    {
        $request = $this->acquireLoginRequest();
        $errors = Errors::create();

        $user = $this->userRepository->getByEmail($request->getEmail());

        if ($user === null || !password_verify($request->getPassword(), $user->getPassword())) {
            $errors->add("user", "Invalid email or password");
        }

        if ($errors->hasNone()) {
            $this->startSession();
            $_SESSION["user_id"] = $user->getId();

            header("Location: /home");

        } else {
            require_once $this->renderer->render("login.phtml", "Login");
        }
    }

    public function logout(): void
    {
        $this->startSession();

        unset($_SESSION["user_id"]);
        header("Location: /home");
    }

    private function startSession(): void
    {
        set_error_handler(function() {}, E_WARNING);

        if (session_status() != PHP_SESSION_ACTIVE)
            session_start();

        restore_error_handler();
    }

    public function register(): void
    {
        $request = $this->acquireRegistrationRequest();
        $errors = $this->validateRegistration($request);

        if ($errors->hasNone()) {
            $this->userRepository->save(new User(
                $request->getName(),
                $request->getEmail(),
                password_hash($request->getPassword(), PASSWORD_DEFAULT)
            ));

            $user = $this->userRepository->getByEmail($request->getEmail());

            $this->profileRepository->save(new Profile(
                $user->getId()
            ));

            $this->cartRepository->save(new Cart(
                0,
                $user->getId()
            ));

            header("Location: /login");

        } else {
            require_once $this->renderer->render("registration.phtml", "Registration");
        }
    }

    public function validateRegistration(RegistrationRequest $request): Errors
    {
        $errors = Errors::create();

        if ($this->userRepository->getByEmail($request->getEmail()) !== null) {
            $errors->add("email", "Email is already taken");
        }

        if (!filter_var($request->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors->add("email", "Invalid email");
        }

        if ($request->getPassword() !== $request->getPasswordRepeat()) {
            $errors->add("password", "Invalid password");
        }

        $nameLength = strlen($request->getName());

        if ($nameLength <= 4 || $nameLength >= 255) {
            $errors->add("name", "Invalid name");
        }

        return $errors;
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

    private function acquireRegistrationRequest(): RegistrationRequest
    {
        $name = $_REQUEST["name"];
        $email = $_REQUEST["email"];
        $password = $_REQUEST["psw"];
        $passwordRepeat = $_REQUEST["psw-repeat"];

        return new RegistrationRequest($name, $email, $password, $passwordRepeat);
    }
}
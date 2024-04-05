<?php

namespace controller;

class LoginController {
    public function get(): void {
        require_once "./../view/login.phtml";
    }

}
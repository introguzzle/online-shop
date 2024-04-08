<?php

namespace controller;

use service\ProfileService;
use session\AuthHolder;

class ProfileController extends Controller {


    private ProfileService $service;

    public function __construct() {
        parent::__construct();

        $this->service = new ProfileService();
    }

    public function get(): void {
        $user = AuthHolder::getCurrentUser();

        if (isset($user)) {
            $name = $user->getName();
            $email = $user->getEmail();

            require_once $this->renderer->render("profile.phtml");
        } else {
            require_once $this->renderer->render("404.phtml");
        }
    }

    public function post(): void {

    }

    public function getEditDescription(): void {
        require_once $this->renderer->render("profile_edit_description.phtml");
    }

    public function postEditDescription(): void {

    }
}
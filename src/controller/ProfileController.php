<?php

namespace controller;

use service\ProfileService;
use session\Authentication;

class ProfileController extends Controller {

    private ProfileService $service;

    public function __construct() {
        parent::__construct();

        $this->service = new ProfileService();
    }

    public function view(): void {
        $user = Authentication::getUser();

        if (isset($user)) {
            $name = $this->service->getName();
            $email = $this->service->getEmail();
            $description = $this->service->getDescription();

            if ($this->service->getAvatarUrl() !== "-1")
                $avatar = $this->service->getAvatarUrl();

            require_once $this->renderer->render("profile.phtml", "Profile");
        } else {
            require_once $this->renderer->render("404.phtml", "404");
        }
    }

    public function post(): void {

    }

    public function getEditDescription(): void {
        require_once $this->renderer
            ->render("profile_edit_description.phtml", "Edit description");
    }

    public function postEditDescription(): void {
        if ($this->service->proceedEdit())
            header("Location: /profile");
    }
}
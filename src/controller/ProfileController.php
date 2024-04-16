<?php

namespace controller;

use repository\CartBookRepository;
use repository\UserRepository;
use service\ProfileService;
use session\Authentication;

class ProfileController extends Controller
{

    private ProfileService $profileService;

    public function __construct()
    {
        parent::__construct();

        $this->profileService = new ProfileService();
    }

    public function view(): void
    {
        $profileView = $this->profileService->getProfileView();

        if ($profileView !== null) {
            require_once $this->renderer->render("profile.phtml", "Profile");

        } else {
            require_once $this->renderer->render("404.phtml", "404");
        }
    }

    private function acquireNewDescription(): string
    {
        return $_REQUEST["description"];
    }

    public function getDescriptionEdit(): void
    {
        require_once $this->renderer->render(
            "profile_edit_description.phtml",
            "Edit description"
        );
    }

    public function postDescriptionEdit(): void
    {
        $user = Authentication::getUser();
        $errors = $this->profileService->processDescriptionEdit(
            $user->getId(),
            $this->acquireNewDescription()
        );

        if ($errors->hasNone()) {
            header("Location: /profile");

        } else {
            require_once $this->renderer->render(
                "profile_edit_description.phtml",
                "Edit description"
            );
        }
    }
}
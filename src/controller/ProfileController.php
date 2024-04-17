<?php

namespace controller;

use service\authentication\Authentication;
use service\ProfileService;

class ProfileController extends Controller
{

    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        parent::__construct();
        $this->profileService = $profileService;
    }

    public function view(): void
    {
        $profileView = $this->profileService->getProfileView();

        require_once $this->renderer->render("profile.phtml", "Profile");
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
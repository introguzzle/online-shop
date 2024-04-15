<?php

namespace service;

use entity\Profile;
use entity\User;
use repository\ProfileRepository;
use session\Authentication;

class ProfileService implements Service {


    private ProfileRepository $profileRepository;

    public function __construct() {
        $this->profileRepository = new ProfileRepository();
    }

    public function processDescriptionEdit(): bool {
        $id = Authentication::getUser()->getId();

        return $this->profileRepository->updateDescriptionById($id, $this->description());
    }

    public function saveProfile(User $user): void {
        $profile = new Profile($user->getId());
        $this->profileRepository->save($profile);
    }

    public function getName(): string {
        return Authentication::getName();
    }

    public function getEmail(): string {
        return Authentication::getEmail();
    }

    public function getDescription(): string {
        return $this->profileRepository
            ->getByUserId(Authentication::getUser()->getId())
            ->getDescription();
    }

    public function getAvatarUrl(): string {
        return $this->profileRepository
            ->getByUserId(Authentication::getUser()->getId())
            ->getAvatarUrl();
    }
}
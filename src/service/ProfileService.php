<?php

namespace service;

use dto\Profile;
use dto\User;
use repository\ProfileRepository;
use session\Authentication;

class ProfileService {


    private ProfileRepository $profileRepository;

    public function __construct() {
        $this->profileRepository = new ProfileRepository();
    }

    public function proceedEdit(): bool {
        $id = Authentication::getUser()->getId();

        return $this->profileRepository->updateDescriptionById($id, $this->description());
    }

    public function saveProfile(User $user): void {
        $profile = new Profile(0, $user->getId());
        $this->profileRepository->save($profile);
    }

    private function description(): string {
        return $_REQUEST["description"];
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
<?php

namespace service;

use dto\Errors;
use entity\Profile;
use entity\User;
use modelview\ProfileView;
use repository\ProfileRepository;
use session\Authentication;
use session\NotAuthenticatedException;
use Throwable;

class ProfileService implements Service
{

    private ProfileRepository $profileRepository;

    public function __construct() {
        $this->profileRepository = new ProfileRepository();
    }

    public function processDescriptionEdit(int $userId, string $description): Errors
    {
        $errors = $this->validate($description);

        if ($errors->hasAny()) {
            return $errors;
        }

        $profile = $this->getByUserId($userId);

        $this->updateDescriptionById($profile->getId(), $description);

        return $errors;
    }

    public function saveProfile(User $user): void
    {
        $profile = new Profile($user->getId());
        $this->save($profile);
    }

    private function updateDescriptionById(int $id, string $description): bool
    {
        $this->profileRepository->updateDescriptionById($id, $description);

        return true;
    }

    private function getByUserId(int $userId): ?Profile
    {
        return $this->profileRepository->getByUserId($userId);
    }

    private function validate(string $description): Errors
    {
        $errors = Errors::create();

        return $errors;
    }

    private function save(Profile $profile): bool
    {
        $this->profileRepository->save($profile);

        return true;
    }

    public function getProfileView(): ?ProfileView
    {
        try {
            $user = Authentication::getUser();
            $profile = $this->profileRepository->getByUserId($user->getId());

            return new ProfileView($profile, $user);
        } catch (NotAuthenticatedException $e) {
            return null;
        }
    }

    public function getDescription(): string
    {
        return $this->profileRepository
            ->getByUserId(Authentication::getUser()->getId())
            ->getDescription();
    }

    public function getAvatarUrl(): string
    {
        return $this->profileRepository
            ->getByUserId(Authentication::getUser()->getId())
            ->getAvatarUrl();
    }
}
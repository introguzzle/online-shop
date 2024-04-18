<?php

namespace service;

use dto\Errors;
use entity\Profile;
use entity\User;
use modelview\ProfileView;
use repository\ProfileRepository;
use service\authentication\Authentication;

class ProfileService implements Service
{

    private ProfileRepository $profileRepository;

    public function __construct(ProfileRepository $profileRepository) {
        $this->profileRepository = $profileRepository;
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

    public function saveProfile(User $user): Profile
    {
        $profile = new Profile($user->getId());
        return $this->save($profile);
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

    private function save(Profile $profile): ?Profile
    {
        return $this->profileRepository->save($profile);
    }

    public function getProfileView(): ?ProfileView
    {
        $user = Authentication::getUser();
        $profile = $this->profileRepository->getByUserId($user->getId());

        return new ProfileView($profile, $user);
    }
}
<?php

namespace service;

use dto\RegistrationDTO;
use entity\Profile;
use repository\connection\DefaultConnection;
use repository\UserRepository;
use entity\User;
use Throwable;

class RegistrationService implements Service
{
    private UserRepository $userRepository;
    private ProfileService $profileService;

    public function __construct(
        UserRepository $userRepository,
        ProfileService $profileService,
    )
    {
        $this->userRepository = $userRepository;
        $this->profileService = $profileService;
    }

    public function processRegistration(
        RegistrationDTO $registrationDTO
    ): bool
    {
        $connection = new DefaultConnection();

        if (!$connection->startTransaction()) {
            return false;
        }

        $user = $this->createUser($registrationDTO);

        try {
            $user = $this->saveUser($user);
            $this->saveProfile($user);

            $connection->commit();

        } catch (Throwable $t) {
            $connection->rollback();
            return false;
        }

        return true;
    }

    private function createUser(RegistrationDTO $form): User
    {
        return new User(
            $form->getName(),
            $form->getEmail(),
            password_hash($form->getPassword(), PASSWORD_DEFAULT)
        );
    }

    public function saveUser(User $user): User
    {
        return $this->userRepository->save($user);
    }

    public function saveProfile(User $user): Profile
    {
        return $this->profileService->saveProfile($user);
    }
}
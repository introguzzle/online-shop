<?php

namespace service;

use dto\Errors;
use dto\RegistrationDTO;
use entity\Profile;
use repository\UserRepository;
use entity\User;
use Throwable;
use validation\RegistrationValidator;
use validation\Validator;

class RegistrationService implements Service
{
    private UserRepository $userRepository;
    private ProfileService $profileService;
    private Validator $validator;

    public function __construct(
        UserRepository $userRepository,
        ProfileService $profileService,
        RegistrationValidator $validator
    )
    {
        $this->userRepository = $userRepository;
        $this->profileService = $profileService;
        $this->validator = $validator;
    }

    public function processRegistration(
        RegistrationDTO $registrationDTO
    ): Errors
    {
        $errors = $this->validate($registrationDTO);

        try {
            $this->userRepository->beginTransaction();

            if ($errors->hasAny()) {
                return $errors;
            }

            $user = $this->saveUser($this->createUser($registrationDTO));

            if ($user === null) {
                $this->rollback();
                return $errors;
            }

            $profile = $this->saveProfile($user);

            if ($profile === null) {
                $this->rollback();
                return $errors;
            }

            $this->userRepository->commit();

        } catch (Throwable $t) {
            $errors->add("internal", "Internal server error");
            $this->rollback();
        }

        return $errors;
    }

    private function validate(RegistrationDTO $dto): Errors
    {
        return $this->validator->validate($dto);
    }

    private function createUser(RegistrationDTO $form): User
    {
        return new User(
            $form->getName(),
            $form->getEmail(),
            password_hash($form->getPassword(), PASSWORD_DEFAULT)
        );
    }

    public function saveUser(User $user): ?User
    {
        return $this->userRepository->save($user);
    }

    public function saveProfile(User $user): ?Profile
    {
        return $this->profileService->saveProfile($user);
    }

    private function rollback(): void
    {
        $this->userRepository->rollback();
    }
}
<?php

namespace session;

use entity\User;
use service\SessionAuthenticationService;

final class Authentication
{

    public static function getUser(): ?User
    {
        $service = new SessionAuthenticationService();
        $user = $service->getUser();

        if ($user === null) {
            throw new NotAuthenticatedException();
        } else {
            return $user;
        }
    }

    public static function getEmail(): string
    {
        $service = new SessionAuthenticationService();
        $user = $service->getUser();

        if ($user === null) {
            throw new NotAuthenticatedException();
        } else {
            return $user->getEmail();
        }
    }

    public static function getName(): string
    {
        $service = new SessionAuthenticationService();
        $user = $service->getUser();

        if ($user === null) {
            throw new NotAuthenticatedException();
        } else {
            return $user->getName();
        }
    }

    public static function getRole(): int
    {
        $service = new SessionAuthenticationService();
        $user = $service->getUser();

        if ($user === null) {
            throw new NotAuthenticatedException();
        } else {
            return $user->getRoleId();
        }
    }
}
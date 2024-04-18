<?php

namespace service\authentication;

use entity\User;

final class Authentication
{
    private static AuthenticationService $authenticationService;
    private static ?User $user;

    public static function init(
        AuthenticationService $authenticationService
    ): void
    {
        self::$authenticationService = $authenticationService;
    }

    public static function getUser(): ?User
    {
        if (!isset(self::$user)) {
            self::$user = self::$authenticationService->getUser();
        }

        return self::$user;
    }

    public static function getEmail(): string
    {
        if (!isset(self::$user)) {
            self::$user = self::$authenticationService->getUser();
        }

        return self::$user->getEmail();
    }

    public static function getName(): string
    {
        if (!isset(self::$user)) {
            self::$user = self::$authenticationService->getUser();
        }

        return self::$user->getName();
    }

    public static function getRole(): int
    {
        if (!isset(self::$user)) {
            self::$user = self::$authenticationService->getUser();
        }

        return self::$user->getRoleId();
    }
}
<?php

namespace service\authentication;

use entity\User;

final class Authentication
{
    private static AuthenticationService $authenticationService;

    public static function init(
        AuthenticationService $authenticationService
    ): void
    {
        self::$authenticationService = $authenticationService;
    }

    public static function getUser(): ?User
    {
        return self::$authenticationService->getUser();
    }

    public static function getEmail(): string
    {
        return self::$authenticationService->getUser()->getEmail();
    }

    public static function getName(): string
    {
        return self::$authenticationService->getUser()->getName();
    }

    public static function getRole(): int
    {
        return self::$authenticationService->getUser()->getRoleId();
    }
}
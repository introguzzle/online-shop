<?php

namespace service\authentication;

use entity\User;
use Throwable;

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

    public static function isAuthenticated(): bool
    {
        try {
            return self::$authenticationService->isAuthenticated();
        } catch (Throwable $t) {
            return false;
        }
    }

    public static function getUser(): ?User
    {
        if (!isset(self::$user)) {
            self::$user = self::$authenticationService->getUser();
        }

        return self::$user ?? null;
    }

    public static function getEmail(): ?string
    {
        if (!isset(self::$user)) {
            self::$user = self::$authenticationService->getUser();
        }

        try {
            return self::$user->getEmail();
        } catch (Throwable $t) {
            return null;
        }
    }

    public static function getName(): ?string
    {
        if (!isset(self::$user)) {
            self::$user = self::$authenticationService->getUser();
        }

        try {
            return self::$user->getName();
        } catch (Throwable $t) {
            return null;
        }
    }

    public static function getRole(): ?int
    {
        if (!isset(self::$user)) {
            self::$user = self::$authenticationService->getUser();
        }

        try {
            return self::$user->getRoleId();
        } catch (Throwable $t) {
            return null;
        }
    }
}
<?php

namespace session;

use dto\User;
use service\SessionAuthenticationService;

class Authentication {

    public static function getUser(): ?User {
        $service = new SessionAuthenticationService();
        return $service->getUser();
    }

    public static function getEmail(): string {
        $service = new SessionAuthenticationService();
        return $service->getUser()->getEmail();
    }

    public static function getName(): string {
        $service = new SessionAuthenticationService();
        return $service->getUser()->getName();
    }

    public static function getRole(): int {
        $service = new SessionAuthenticationService();
        return $service->getUser()->getRoleId();
    }
}
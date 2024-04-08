<?php

namespace session;

use dto\User;
use service\SessionAuthenticationService;

class AuthHolder {
    private static ?User $user;

    public static function getCurrentUser(): ?User {
        if (!isset(self::$user)) {
            $s = new SessionAuthenticationService();
            self::$user = $s -> getCurrentUser();
        }

        return self::$user;
    }
}
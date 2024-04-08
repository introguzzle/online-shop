<?php

namespace service;

use dto\User;

interface AuthenticationService {
    function check(): bool;
    function getCurrentUser(): User|null;
    function login(User $user): bool;
    function logout(): void;
}
<?php

namespace service;

use dto\User;

interface AuthenticationService extends Service {
    function isAuthenticated(): bool;
    function getUser(): ?User;
    function login(User $user): bool;
    function logout(): void;
}
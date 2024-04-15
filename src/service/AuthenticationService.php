<?php

namespace service;

use dto\LoginForm;
use entity\User;

interface AuthenticationService extends Service {
    function isAuthenticated(): bool;
    function getUser(): ?User;
    function loginByUser(User $user): bool;
    function loginByCredentials(LoginForm $loginForm): bool;
    function logout(): void;
}
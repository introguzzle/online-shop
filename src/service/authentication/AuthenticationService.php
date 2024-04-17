<?php

namespace service\authentication;

use dto\LoginDTO;
use entity\User;
use service\Service;

interface AuthenticationService extends Service {
    function isAuthenticated(): bool;
    function getUser(): ?User;
    function loginByUser(User $user): bool;
    function loginByCredentials(LoginDTO $loginDTO): bool;
    function logout(): void;
}
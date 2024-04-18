<?php

namespace service\authentication;

use dto\LoginDTO;
use entity\User;
use service\Service;

interface AuthenticationService extends Service {
    public function isAuthenticated(): bool;
    public function getUser(): ?User;
    public function loginByUser(User $user): bool;
    public function loginByCredentials(LoginDTO $loginDTO): bool;
    public function logout(): void;
}
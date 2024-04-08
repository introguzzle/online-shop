<?php

namespace service;

class ProfileService {

    public function proceedEdit(): bool {

    }

    private function description(): string {
        return $_REQUEST["description"];
    }
}
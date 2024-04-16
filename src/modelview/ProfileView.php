<?php

namespace modelview;

use entity\Profile;
use entity\User;

class ProfileView
{
    private Profile $profile;
    private User $user;

    public function __construct(Profile $profile, User $user)
    {
        $this->profile = $profile;
        $this->user = $user;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
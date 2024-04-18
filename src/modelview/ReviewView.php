<?php

namespace modelview;

use entity\Review;
use entity\User;

class ReviewView
{
    private Review $review;
    private User $user;

    public function __construct(Review $review, User $user)
    {
        $this->review = $review;
        $this->user = $user;
    }

    public function getReview(): Review
    {
        return $this->review;
    }

    public function getUser(): User
    {
        return $this->user;
    }


}
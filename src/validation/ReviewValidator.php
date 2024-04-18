<?php

namespace validation;

use dto\DTO;
use dto\Errors;
use dto\ReviewDTO;

class ReviewValidator implements Validator
{

    public function validate(ReviewDTO | DTO $dto): Errors
    {
        $errors = Errors::create();

        return $errors;
    }
}
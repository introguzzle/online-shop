<?php

namespace validation;

use dto\DTO;
use dto\Errors;
use dto\OrderDTO;

class OrderValidator implements Validator
{

    public function validate(OrderDTO | DTO $dto): Errors
    {
        $errors = Errors::create();

        return $errors;
    }
}
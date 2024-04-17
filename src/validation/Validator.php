<?php

namespace validation;

use dto\DTO;
use dto\Errors;

interface Validator
{
    public function validate(DTO $dto): Errors;
}
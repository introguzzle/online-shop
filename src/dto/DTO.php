<?php

namespace dto;

use Stringable;
use util\StringConverter;

abstract class DTO implements Stringable
{
    public function __toString(): string
    {
        return StringConverter::toString($this);
    }
}
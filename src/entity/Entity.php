<?php

namespace entity;

use Stringable;
use util\StringConverter;

abstract class Entity implements Stringable
{
    public function __toString(): string
    {
        return StringConverter::toString($this);
    }
}
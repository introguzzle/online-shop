<?php

namespace session;

use RuntimeException;
use Throwable;

class NotAuthenticatedException extends RuntimeException
{
    public function __construct(
        string     $message = "",
        int        $code = 0,
        ?Throwable $cause = null
    )
    {
        parent::__construct($message, $code, $cause);
    }
}
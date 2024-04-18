<?php

namespace repository\connection;

use Exception;
use RuntimeException;
use Throwable;

class ConnectionException extends RuntimeException
{
    public function __construct(
        string $message = "",
        int $code = 0,
        ?Throwable $cause = null
    )
    {
        parent::__construct($message, $code, $cause);
    }

}
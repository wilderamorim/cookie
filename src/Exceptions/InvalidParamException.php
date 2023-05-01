<?php

namespace ElePHPant\Cookie\Exceptions;

use InvalidArgumentException;
use Throwable;

class InvalidParamException extends InvalidArgumentException
{
    public function __construct($message = 'Invalid parameter', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

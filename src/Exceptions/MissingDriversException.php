<?php

namespace ElePHPant\Cookie\Exceptions;

use Exception;

class MissingDriversException extends Exception
{
    public function __construct(array $missingDrivers)
    {
        $missingDriversStr = implode(', ', $missingDrivers);
        $message = "Missing drivers: $missingDriversStr";
        parent::__construct($message);
    }
}

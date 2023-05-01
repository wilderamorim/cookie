<?php

namespace ElePHPant\Cookie\Exceptions;

use Exception;

class InvalidValueException extends Exception
{
    public function __construct(array $invalidValues)
    {
        $invalidValuesStr = implode(', ', $invalidValues);
        $message = "Invalid value(s) for key(s): $invalidValuesStr";
        parent::__construct($message);
    }
}

<?php

namespace ElePHPant\Cookie\Exceptions;

use Exception;

class EmptyValuesException extends Exception
{
    public function __construct(array $emptyValues)
    {
        $emptyValuesStr = implode(', ', $emptyValues);
        $message = "Empty values for drivers: $emptyValuesStr";
        parent::__construct($message);
    }
}

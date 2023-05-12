<?php

namespace ElePHPant\Cookie\Exceptions;

use Exception;

class InvalidOptionException extends Exception
{
    public function __construct(array $invalidOptions)
    {
        $invalidOptionsStr = implode(', ', $invalidOptions);
        $message = "Invalid option driver(s): $invalidOptionsStr";
        parent::__construct($message);
    }
}

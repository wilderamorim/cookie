<?php

namespace ElePHPant\Cookie\Exceptions;

use Exception;

class InvalidConfigException extends Exception
{
    public function __construct(array $invalidConfigs)
    {
        $invalidConfigsStr = implode(', ', $invalidConfigs);
        $message = "Invalid config driver(s): $invalidConfigsStr";
        parent::__construct($message);
    }
}

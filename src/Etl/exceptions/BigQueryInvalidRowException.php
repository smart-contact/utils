<?php

namespace SmartContact\Etl\exceptions;

use Exception;
use Throwable;

class BigQueryInvalidRowException extends Exception
{
    public function __construct($error, Throwable $previous = null)
    {
        $message = $error['reason'] . " : " . $error['message'];
        parent::__construct($message, 400, $previous);
    }
}

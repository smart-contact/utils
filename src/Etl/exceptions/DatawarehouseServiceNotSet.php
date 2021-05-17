<?php

namespace SmartContact\Etl\exceptions;

use Exception;
use Throwable;

class DatawarehouseServiceNotSet extends Exception
{
    public function __construct(Throwable $previous = null)
    {
        $message = "Datawarehouse Service Not Set";
        $code = 404;
        parent::__construct($message, $code, $previous);
    }
}

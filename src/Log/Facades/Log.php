<?php

namespace SmartContact\Log\Facades;

use Illuminate\Support\Facades\Facade;

class Log extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'sclog';
    }
}

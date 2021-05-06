<?php

namespace SmartContact\Responses\Facades;

use Illuminate\Support\Facades\Facade;

class Responses extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'responses';
    }
}

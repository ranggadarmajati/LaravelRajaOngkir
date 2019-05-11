<?php

namespace Rdj\Rajaongkir\Facades;

use Illuminate\Support\Facades\Facade;

class Rajaongkir extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Rajaongkir';
    }
}

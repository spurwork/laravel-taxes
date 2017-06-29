<?php

namespace Appleton\Taxes\Facades;

use Illuminate\Support\Facades\Facade;

class Taxes extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'taxes';
    }
}

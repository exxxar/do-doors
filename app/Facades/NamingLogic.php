<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Classes\NamingLogic query()
 * @see \Illuminate\Log\Logger
 */
class NamingLogic extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'naming.service';
    }
}

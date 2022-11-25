<?php

namespace Makkinga\TrustedDevices\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Makkinga\TrustedDevices\TrustedDevices
 */
class TrustedDevices extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Makkinga\TrustedDevices\TrustedDevices::class;
    }
}

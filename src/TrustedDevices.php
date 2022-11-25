<?php

namespace Makkinga\TrustedDevices;

class TrustedDevices
{
    /**
     * Get active guard
     *
     * @return int|mixed|string|null
     */
    static function getActiveGuard()
    {
        foreach (array_keys(config('auth.guards')) as $guard) {
            if (auth()->guard($guard)->check()) {
                return $guard;
            }
        }

        return null;
    }
}

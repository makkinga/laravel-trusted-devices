<?php

namespace Makkinga\TrustedDevices;

use Illuminate\Support\Str;
use Jenssegers\Agent\Facades\Agent;

class TrustedDevices
{
    /**
     * Get active guard
     *
     * @return int|mixed|string|null
     */
    static function getActiveGuard()
    {
        if (config('trusted-devices.guard')) {
            return config('trusted-devices.guard');
        }

        foreach (array_keys(config('auth.guards')) as $guard) {
            if (auth()->guard($guard)->check()) {
                return $guard;
            }
        }

        return null;
    }

    /**
     * Create new trusted device from current device
     *
     * @return int|mixed|string|null
     */
    static function new($user)
    {
        $hash = md5(serialize([
            'ip'          => request()->ip(),
            'device'      => Agent::device(),
            'device_type' => Agent::deviceType(),
            'platform'    => Agent::platform(),
            'browser'     => Agent::browser(),
            'user_agent'  => request()->userAgent(),
        ]));

        $user->trustedDevices()->create([
            'id'          => Str::uuid(),
            'ip'          => request()->ip(),
            'device'      => Agent::device(),
            'device_type' => Agent::deviceType(),
            'platform'    => Agent::platform(),
            'browser'     => Agent::browser(),
            'user_agent'  => request()->userAgent(),
            'trusted'     => true,
            'last_seen'   => now(),
            'hash'        => $hash,
        ]);
    }
}

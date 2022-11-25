<?php

namespace Makkinga\TrustedDevices\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Http\RedirectResponse;
use Makkinga\TrustedDevices\Notifications\DeviceNotTrusted;

class EnsureDeviceIsTrusted
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() || $request->routeIs('trusted-devices.not-trusted')) {
            return $next($request);
        }

        $hash = md5(serialize([
            'ip'          => $request->ip(),
            'device'      => Agent::device(),
            'device_type' => Agent::deviceType(),
            'platform'    => Agent::platform(),
            'browser'     => Agent::browser(),
            'user_agent'  => $request->userAgent(),
        ]));

        $device = $request->user()->trustedDevices->where('hash', $hash)->first();

        if ($device) {
            if ($device->trusted) {
                $device->last_seen = now();
                $device->save();

                return $next($request);
            }
        } else {
            $device = $request->user()->trustedDevices()->create([
                'id'          => Str::uuid(),
                'ip'          => $request->ip(),
                'device'      => Agent::device(),
                'device_type' => Agent::deviceType(),
                'platform'    => Agent::platform(),
                'browser'     => Agent::browser(),
                'user_agent'  => $request->userAgent(),
                'trusted'     => false,
                'hash'        => $hash,
            ]);
        }

        $verificationToken          = Str::uuid();
        $device->verification_token = bcrypt($verificationToken);
        $device->last_seen = now();
        $device->save();

        $request->user()->notify(new DeviceNotTrusted($device, $verificationToken));

        return redirect()->route('trusted-devices.not-trusted');

//        return $next($request);
    }
}

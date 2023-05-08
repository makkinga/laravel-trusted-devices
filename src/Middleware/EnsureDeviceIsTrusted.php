<?php

namespace Makkinga\TrustedDevices\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Http\RedirectResponse;
use Makkinga\TrustedDevices\Facades\TrustedDevices;
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
        # No need for checking on the not trusted route..
        if ($request->routeIs('trusted-devices.not-trusted')) {
            return $next($request);
        }

        # ..Or if there is no user..
        if (! ($user = auth()->guard(TrustedDevices::getActiveGuard())->user())) {
            return $next($request);
        }

        # ..Or the user's model doesn't use the HasTrustedDevices trait
        if (! in_array('Makkinga\TrustedDevices\Traits\HasTrustedDevices', class_uses($user))) {
            return $next($request);
        }

        # Creating a hash to ensure we're looking for the correct device
        $hash = md5(serialize([
            'ip'          => $request->ip(),
            'device'      => Agent::device(),
            'device_type' => Agent::deviceType(),
            'platform'    => Agent::platform(),
            'browser'     => Agent::browser(),
            'user_agent'  => $request->userAgent(),
        ]));

        # Getting the existing device if one exists for the current session
        $device = $user->trustedDevices->where('hash', $hash)->first();

        if ($device) {
            # If it is, and its also trusted, update last seen and lets gooo!
            if ($device->trusted) {
                $device->last_seen = now();
                $device->save();

                return $next($request);
            }
        } else {
            # If not, create one..
            $device = $user->trustedDevices()->create([
                'id'          => Str::uuid(),
                'ip'          => $request->ip(),
                'device'      => Agent::device(),
                'device_type' => Agent::deviceType(),
                'platform'    => Agent::platform(),
                'browser'     => Agent::browser(),
                'user_agent'  => $request->userAgent(),
                'trusted'     => ! $user->trustedDevices->count() && config('trusted-devices.trust_first_device'),
                'hash'        => $hash,
                'last_seen'   => now(),
            ]);
        }

        # ..Generate a token to verify it..
        $verificationToken          = Str::uuid();
        $device->verification_token = bcrypt($verificationToken);
        $device->last_seen          = now();

        # ..Save it..
        $device->save();

        # If not trusted
        if (! $device->trusted) {
            # ..notify the user
            $user->notify(new DeviceNotTrusted($device, $verificationToken));

            # Sorry sir, but your device is not trusted
            return redirect()->route('trusted-devices.not-trusted');
        }

        # If it is trusted, leave the user in peace
        return $next($request);
    }
}

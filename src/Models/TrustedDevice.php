<?php

namespace Makkinga\TrustedDevices\Models;

use Jenssegers\Agent\Facades\Agent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrustedDevice extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];
    protected $appends = ['is_current'];
    protected $casts = [
        'last_seen' => 'datetime',
    ];

    /**
     * User Relationship
     *
     * @return MorphTo
     */
    public function user()
    {
        return $this->morphTo();
    }

    /**
     * Returns the location
     *
     * @return mixed
     */
    public function location()
    {
        $token      = env('TRUSTED_DEVICES_IPINFO_TOKEN');
        $tokenQuery = $token ? "?token=$token" : '';
        $location   = json_decode(file_get_contents("http://ipinfo.io/{$this->ip}/json$tokenQuery"));

        if (isset($location->bogon) && $location->bogon) {
            return null;
        }

        return "$location->city ($location->country)";
    }

    /**
     * Returns the is_current attribute
     *
     * @return mixed
     */
    public function getIsCurrentAttribute()
    {
        $hash = md5(serialize([
            'ip'          => request()->ip(),
            'device'      => Agent::device(),
            'device_type' => Agent::deviceType(),
            'platform'    => Agent::platform(),
            'browser'     => Agent::browser(),
            'user_agent'  => request()->userAgent(),
        ]));

        return $this->hash === $hash;
    }
}

<?php

namespace Makkinga\TrustedDevices\Traits;

use Makkinga\TrustedDevices\Models\TrustedDevice;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTrustedDevices
{
    /**
     * TrustedDevice relationship
     *
     * @return MorphMany
     */
    public function trustedDevices(): MorphMany
    {
        return $this->morphMany(TrustedDevice::class, 'user');
    }
}
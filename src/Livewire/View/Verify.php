<?php

namespace Makkinga\TrustedDevices\Livewire\View;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Makkinga\TrustedDevices\Models\TrustedDevice;
use Illuminate\Contracts\Container\BindingResolutionException;

class Verify extends Component
{
    public TrustedDevice $device;
    public string $token;

    /**
     * Mount
     *
     * @param TrustedDevice $device
     * @param string $token
     * @return void
     */
    public function mount(TrustedDevice $device, string $token)
    {
        $this->device = $device;
        $this->token  = $token;
    }

    /**
     * Render
     *
     * @return bool|Response|Application|Factory|View|mixed
     * @throws BindingResolutionException
     */
    public function render()
    {
        if (Hash::check($this->token, $this->device->verification_token)) {
            $verified = true;

            $this->device->trusted           = true;
            $this->device->verification_token = null;
            $this->device->save();
        }

        return view('trusted-devices::trusted-devices.verify', [
            'verified' => $verified ?? false,
        ])->layout(config('trusted-devices.layout'));
    }
}

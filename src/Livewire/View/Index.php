<?php

namespace Makkinga\TrustedDevices\Livewire\View;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Makkinga\TrustedDevices\Facades\TrustedDevices;
use Illuminate\Contracts\Container\BindingResolutionException;

class Index extends Component
{
    /**
     * Render
     *
     * @return bool|Response|Application|Factory|View|mixed
     * @throws BindingResolutionException
     */
    public function render()
    {
        return view('trusted-devices::trusted-devices.index', [
            'trustedDevices' => Auth::guard(TrustedDevices::getActiveGuard())->user()->trustedDevices,
        ])->layout(config('trusted-devices.layout'));
    }
}

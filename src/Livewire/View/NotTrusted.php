<?php

namespace Makkinga\TrustedDevices\Livewire\View;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Container\BindingResolutionException;

class NotTrusted extends Component
{
    /**
     * Render
     *
     * @return bool|Response|Application|Factory|View|mixed
     * @throws BindingResolutionException
     */
    public function render()
    {
        return view('trusted-devices::trusted-devices.not-trusted')->layout(config('trusted-devices.layout'));
    }
}

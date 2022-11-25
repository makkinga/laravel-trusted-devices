<?php

namespace Makkinga\TrustedDevices\Livewire\View;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Makkinga\TrustedDevices\Models\TrustedDevice;
use Illuminate\Contracts\Container\BindingResolutionException;


class Edit extends Component
{
    public TrustedDevice $device;
    public $deleteConfirmation;
    protected $rules = [
        'device.name' => 'sometimes',
    ];

    /**
     * Render
     *
     * @return bool|Response|Application|Factory|View|mixed
     * @throws BindingResolutionException
     */
    public function render()
    {
        return view('trusted-devices::trusted-devices.edit')->layout(config('trusted-devices.layout'));
    }

    /**
     * Submit
     *
     * @return void
     */
    public function submit()
    {
        $this->device->save();

        session()->flash('success', trans('trusted-devices::general.save_successful'));
    }

    /**
     * Delete
     *
     * @return RedirectResponse
     */
    public function delete()
    {
        $this->device->delete();

        return redirect()->route('trusted-devices.index');
    }
}

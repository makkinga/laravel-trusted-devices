<?php

use Illuminate\Support\Facades\Route;
use Makkinga\TrustedDevices\Livewire\View\Edit;
use Makkinga\TrustedDevices\Livewire\View\Index;
use Makkinga\TrustedDevices\Livewire\View\Verify;
use Makkinga\TrustedDevices\Livewire\View\NotTrusted;

Route::middleware(config('trusted-devices.middleware'))->prefix(trans('trusted-devices::general.url.trusted_devices'))->name('trusted-devices.')->group(function () {
    Route::get(trans('trusted-devices::general.url.not_trusted'), NotTrusted::class)->name('not-trusted');
    Route::get('verify/{device:id}/{token}', Verify::class)->name('verify');

    Route::middleware('trusted')->group(function () {
        Route::get('/', Index::class)->name('index');
        Route::get('{device}', Edit::class)->name('edit');
    });
});

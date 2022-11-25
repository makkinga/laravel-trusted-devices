<?php

namespace Makkinga\TrustedDevices;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Makkinga\TrustedDevices\Livewire\View\Edit;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;

class TrustedDevicesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('trusted-devices')
            ->hasConfigFile()
            ->hasRoute('trusted-devices')
            ->hasViews()
            ->hasTranslations()
            ->hasMigration('create_trusted_devices_table')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('makkinga/laravel-trusted-devices')
                    ->endWith(function (InstallCommand $command) {
                        $command->info('Have a great day!');
                    });
            });
    }

    public function boot()
    {
        parent::boot();

        Livewire::component('makkinga.trusted-devices.livewire.view.index', Edit::class);
        Livewire::component('makkinga.trusted-devices.livewire.view.edit', Edit::class);
        Livewire::component('makkinga.trusted-devices.livewire.view.not-trusted', Edit::class);
        Livewire::component('makkinga.trusted-devices.livewire.view.not-verify', Edit::class);
    }
}

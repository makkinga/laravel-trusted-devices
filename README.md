![](https://github.com/makkinga/laravel-trusted-devices/blob/main/banner.png?raw=true)

## Installation

You can install the package via composer:

```bash
composer require makkinga/laravel-trusted-devices
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="trusted-devices-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="trusted-devices-config"
```

This is the contents of the published config file:

```php
return [
    # Overwrite the auto detection of the guard
    'guard'      => null,
    
    # The layout to use for the views
    'layout'     => 'layouts.app',
    
    # The middleware to use for the routes
    'middleware' => ['web', 'auth'],
    
    # Automatically trust the first device
    'trust_first_device' => true
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="trusted-devices-views"
```

### IpInfo
In order to make use of IpInfo.io's free 50k requests per month rate limit, add your API token to your .env:

```dotenv
TRUSTED_DEVICES_IPINFO_TOKEN="{your_token}"
```

## Usage

Prepare your user model by adding the `HasTrustedDevices` trait and also make sure it is using the `Notifiable` trait:

```php
use Illuminate\Notifications\Notifiable;
use Makkinga\TrustedDevices\Traits\HasTrustedDevices;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasTrustedDevices;
}
```

Then add the trusted device middleware to your `$routeMiddleware` in `app/Http/Kernel.php`:

```php
use Makkinga\TrustedDevices\Middleware\EnsureDeviceIsTrusted;

protected $routeMiddleware = [
    [...]
    'trusted' => EnsureDeviceIsTrusted::class,
];
```

You can now use the "trusted" middleware on your routes and route groups like this:

```php
Route::middleware(['auth', 'trusted'])->group(function () {
    // Your routes
});
```

```php
Route::get('/my-route', [MyController::class, 'method'])->name('my-route')->middleware('trusted');
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Gydo Makkinga](https://github.com/makkinga)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

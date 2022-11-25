# Add trusted devices to your user models

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
    'layout'     => 'layouts.app',
    'middleware' => ['web', 'auth'],
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

```php
$trustedDevices = new Makkinga\TrustedDevices();
echo $trustedDevices->echoPhrase('Hello, Makkinga!');
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Gydo Makkinga](https://github.com/makkinga)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

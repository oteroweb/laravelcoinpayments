# Laravel CoinPayment
A Library For Checkout with bitcoin in laravel Framework

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

## Install

Via Composer

``` bash
$  composer require oteroweb/laravelcoinpayment "dev-master"

```
or add to your composer json´in require array

``` bash
        "oteroweb/laravelcoinpayment": "dev-master"
```

Add Provider

``` php
oteroweb\LaravelCoinpayment\LaravelCoinpaymentServiceProvider::class,
```

Add Aliases

``` php
'Coinpayment' => oteroweb\LaravelCoinpayment\CoinPaymentsAPI::class,
```

##Configuration

Publish Configuration file
```
php artisan vendor:publish --provider="oteroweb\LaravelCoinPayment\LaravelCoinPaymentServiceProvider" --tag="config"
```

Edit .env

Add these lines at .env file, follow config/coinpayment.php for configuration descriptions.
``` php
BTC_PUBLICKEY=your_public_key
BTC_PRIVATEKEY=your_private_key

```

##Customizing views (Optional)

If you want to customize form, follow these steps.

### 1.Publish view
```
php artisan vendor:publish --provider="oteroweb\LaravelCoinpayment\LaravelCoinpaymentServiceProvider" --tag="views"
```
### 2.Edit your view at /resources/views/vendor/coinpayment/coinpayment.php

## Usage

###Render Shopping Cart Form

``` php
// Soon
```

## API MODULES
### Get Balance
``` php
//soon
```

### Send Money
``` php
{
	// Some code here soon
}

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email oterolopez1990@gmail.com instead of using the issue tracker.

## Credits

- [oteroweb][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


[ico-version]: https://img.shields.io/packagist/v/oteroweb/laravelcoinpayment.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/oteroweb/laravelcoinpayment.svg?style=flat-square


[link-packagist]: https://packagist.org/packages/oteroweb/laravelcoinpayment
[link-downloads]: https://packagist.org/packages/oteroweb/laravelcoinpayment
[link-author]: https://github.com/oteroweb
[link-contributors]: ../../contributors

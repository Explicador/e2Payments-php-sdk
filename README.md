# Explicador e2Payments PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/explicador/e2payments-php-sdk.svg?style=flat-square)](https://packagist.org/packages/explicador/e2payments-php-sdk)
[![Build Status](https://img.shields.io/travis/explicador/e2payments-php-sdk/master.svg?style=flat-square)](https://travis-ci.org/explicador/e2payments-php-sdk)
[![Quality Score](https://img.shields.io/scrutinizer/g/explicador/e2payments-php-sdk.svg?style=flat-square)](https://scrutinizer-ci.com/g/explicador/e2payments-php-sdk)
[![Total Downloads](https://img.shields.io/packagist/dt/explicador/e2payments-php-sdk.svg?style=flat-square)](https://packagist.org/packages/explicador/e2payments-php-sdk)

This package seeks to help php developers implement the [e2Payments](https://e2payments.explicador.co.mz) APIs without much hustle. It is based on the REST API whose documentation is available on [https://e2payments.explicador.co.mz/docs](https://e2payments.explicador.co.mz/docs).

## Installation

You can install the package via composer:

```bash
composer require explicador/e2payments-php-sdk
```

## Usage

``` php
// Set the consumer key and consumer secret as follows
$mpesa = new \Explicador\E2paymentsPhpSdk\Mpesa();
$mpesa->setClientId('your e2payments client id');
$mpesa->setClientSecret('your e2payments client secret');
$mpesa->setWalletId('your walletId from e2payments');// 'live' production environment 

//This creates transaction between an M-Pesa short code to a phone number registered on M-Pesa.

$result = $mpesa->c2b($phone_number, $amount, $reference);
```

## Example

``` php
// Your variables

// The e2payments is REST API based platform
// find or create your credential from: https://e2payments.explicador.co.mz/admin/credentials

$client_id = 'oQPGhzqyDRilpzvTT6g0nhSeomVQ9G7zZrvY4v00'; //you must change
$client_secret = '961022ed-08f6-4980-a1b3-f017fd15b800'; //you must change

// find your wallet_id from: https://e2payments.explicador.co.mz/admin/mpesa
// or in the organizations where you where invited 
// The wallet_id starts by (#), insert here without (#)

$wallet_id = '111111'; //you must change
 
// SDK initiation for mpesa transaction
$mpesa = new \Explicador\E2paymentsPhpSdk\Mpesa([
   'client_secret' => $client_secret,
   'client_id'     => $client_id,
   'wallet_id'     => $wallet_id,
]);

//This creates transaction between an M-Pesa short code to a phone number registered on M-Pesa.
$result = $mpesa->c2b($phone_number, $amount, $reference);

echo var_dump($result);


```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email developers@explicador.co.mz instead of using the issue tracker.

## Credits

- [José Seie](https://github.com/joseseie)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).

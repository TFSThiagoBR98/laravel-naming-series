# Generate Custom Ids for your models

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tfsthiagobr98/laravel-naming-series.svg?style=flat-square)](https://packagist.org/packages/tfsthiagobr98/laravel-naming-series)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/tfsthiagobr98/laravel-naming-series/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/tfsthiagobr98/laravel-naming-series/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/tfsthiagobr98/laravel-naming-series/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/tfsthiagobr98/laravel-naming-series/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/tfsthiagobr98/laravel-naming-series.svg?style=flat-square)](https://packagist.org/packages/tfsthiagobr98/laravel-naming-series)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require tfsthiagobr98/laravel-naming-series
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-naming-series-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-naming-series-config"
```

This is the contents of the published config file:

```php
return [
    'database' => [
        'connection' => null,
        'table' => 'naming_series',
    ],
    'split_with' => '.',
    'initial_increment' => 1000,
];
```

## Usage

```php
use TFSThiagoBR98\LaravelNamingSeries\Contracts\HasNamingSeries;
use TFSThiagoBR98\LaravelNamingSeries\Concerns\UsingNamingSeries;

class Contract extends Model implements HasNamingSeries
{
    use UsingNamingSeries;

    /**
     * Indicates if the model uses unique ids.
     *
     * @var bool
     */
    public $usesUniqueIds = true;

    /**
     * Field => Format list for model fields
     *
     * @var array<string,string>
     */
    public static array $namingSeries = [
        'code' => 'CNT-.YY.MM.####',
    ];

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array
     */
    public function uniqueIds()
    {
        return [
            'code' => 'getSeriesField', // your series field
        ];
    }
```

### Avaliable Aliases
The Serie format must be splited in part with `.` character. For example:
`CNT-.YY.MM.####` where: `CNT-` is a literal string, `YY` and `MM` is a variable and `####` is the sequential number.

 - `#`: Numeric Sequence ()
 - `YY`: Year (2 Digits)
 - `YYYY`: Year (4 Digits)
 - `MM`: Month
 - `MM`: Day
 - `WW`: ISO Week Count
 - `TS`: Timestamp (Miliseconds)
 - `TL`: Timestamp (Seconds)

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Thiago França da Silva](https://github.com/TFSThiagoBR98)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

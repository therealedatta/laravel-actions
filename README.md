# Actions: controller + auth + validation in one class

[![Latest Version on Packagist](https://img.shields.io/packagist/v/therealedatta/laravel-actions.svg?style=flat-square)](https://packagist.org/packages/therealedatta/laravel-actions)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/therealedatta/laravel-actions/run-tests?label=tests)](https://github.com/therealedatta/laravel-actions/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/therealedatta/laravel-actions/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/therealedatta/laravel-actions/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/therealedatta/laravel-actions.svg?style=flat-square)](https://packagist.org/packages/therealedatta/laravel-actions)

This package provides only one class: an Action class that extends the FormRequest class we all know and adapt it slightly so it works as an invokable Controller.

## Installation

```bash
composer require therealedatta/laravel-actions
php artisan actions:install
```

You can publish the action stubs for the make:action commad:

```bash
php artisan actions:stubs
```

## Usage

```bash
php artisan make:action User\EditUser
```

This command will create the `User\Actions\EditUser` class. The actions subfolder can be modified/removed in in the `config/actions.php` file.
The stub used to generate the class can be modified publishing the stub (check installation section).

`handle` should execute the action itself and `__invoke` (or any other method you want to call)
should call handle and return the controller response.

This package executes authorization automatically. By default is true, you can change this in the `config/actions.php` file.

Important: This package does not call validate automatically. You should call `validate` in `handle` method.

```php
public function handle(): User
{
    $validated_data = $this->validate();

    return tap($this->user)->update($validated_data);
}
```

## Testing

We use pint for styling, larastan for static analysis and pest for testing:

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

- Authors:
    - [edatta](https://github.com/therealedatta)
    - [All Contributors](../../contributors)

- Inspiration:
    - [Loris Leiva actions package](https://github.com/lorisleiva/laravel-actions) / [Loris Leiva request/controller article](https://lorisleiva.com/if-formrequests-and-invokable-controllers-had-a-baby/)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

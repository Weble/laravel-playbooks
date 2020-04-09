# Laravel Playbooks.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/weble/laravel-playbooks.svg?style=flat-square)](https://packagist.org/packages/weble/:package_name)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/weble/laravel-playbooks/run-tests?label=tests)](https://github.com/weble/laravel-playbooks/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/weble/laravel-playbooks.svg?style=flat-square)](https://packagist.org/packages/weble/:package_name)


Run different sets of playbooks within your Laravel application.
Inspired and taken (with some liberties) from [Aggregate by Brent](https://github.com/brendt/aggregate.stitcher.io/tree/master/app/App/Console)

## Installation

You can install the package via composer:

```bash
composer require weble/laravel-playbooks
```

## Configuration

```
php artisan vendor:publish --provider="Weble\LaravelPlaybooks\PlaybooksServiceProvider"
```

This is the default content of the config file

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Run only in these environments
    |--------------------------------------------------------------------------
    |
    | Do not allow Playbooks to be run in any environment outside of the ones specified here
    |
    | default: ['local']
     */
    'envs' => [
        'local'
    ],

    /*
    |--------------------------------------------------------------------------
    | Raise PHP memory limit
    |--------------------------------------------------------------------------
    |
    | Raise the default memory limit to avoid issues when running large playbooks.
    | Set to null to disable this feature.
    |
    | default: '20148M'
     */
    'raise_memory_limit' => '2048M',

    /*
    |--------------------------------------------------------------------------
    | Fresh Migration
    |--------------------------------------------------------------------------
    |
    | Run a migrate:refresh command before every playbook run by default.
    | This can be disabled or enabled manually through the
    | --no-migration or --migration options
    |
    | default: true
     */
    'migrate_by_default' => true,

    /*
    |--------------------------------------------------------------------------
    | Playbook path
    |--------------------------------------------------------------------------
    |
    | Choose the root directory where new Playbooks should be created and where
    | the `php artisan playbook:run` command should scan for available playbooks
    | example: 'Console/Playbooks'
    |
    | default: 'Playbooks'
     */
    'path' => 'Playbooks',
];
```
## Usage

***NOTE: By default this package runs a ```migrate:refresh``` command before running every playbook.
You can disable this behaviour in the config or with the manual --no-migration option in the command.***  

First create one (or more) playbooks

```bash
php artisan make:playbook FullPlaybook
```

This playbook will have the `App\Playbooks` namespace and will be saved in `app/Playbooks`.

You can also specify a custom namespace, say, App\Console\Playbooks

```bash
php artisan make:playbook "Console/Playbooks/FullPlaybook"
```
This playbook will have the App\Console\Presenters namespace and will be saved in app/Console/Playbooks.

Now, you're free to write some stuff in it:

```php
<?php

namespace App\Playbooks;

use App\CarType;
use Weble\LaravelPlaybooks\Playbook;

final class CarTypesPlaybook extends Playbook
{
    public function before(): array
    {
        return [
            // List of other playbooks to run before this one
            // ie: BasePlaybook::once()
            // ie: BasePlaybook::times(3) to run it 3 times
        ];
    }

    public function run(): void
    {
        $this->createCarTypes();
    }

    private function createCarTypes(): void
    {
        $types = [
            'Economy' => 3,
            'Business' => 4,
            'Family' => 4,
            'Sport' => 2,
            'Luxury' => 3,
            'Van' => 8,
            'Luxury Van' => 6,
        ];

        foreach ($types as $type => $passengers) {
            factory(CarType::class)->create([
                'title' => [
                    'it' => $type,
                    'en' => $type,
                ],
                'subtitle' => [
                    'it' => 'Adipiscing elit. aute irure dolor',
                    'en' => 'Adipiscing elit. aute irure dolor',
                ],
                'description' => [
                    'it' => 'Lorem ipsum dolor sit amet consecte tur adipiscing elit. aute irure dolor in reprehende.',
                    'en' => 'Lorem ipsum dolor sit amet consecte tur adipiscing elit. aute irure dolor in reprehende.',
                ],
                'max_passengers' => $passengers,
                'max_luggage' => $passengers - 1,
            ]);
        }
    }
    
    public function after(): array
    {
        return [
            // List of other playbooks to run before this one
            // ie: BasePlaybook::once()
            // ie: BasePlaybook::times(3) to run it 3 times
        ];
    }

}

```

Finally, you can run them!

```bash
php artisan playbook:run FullPlaybook
```


### TODO

Write more tests for the run command

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email daniele@weble.it instead of using the issue tracker.

## Credits

- [Daniele Rosario](https://github.com/skullbock)
- [Brent Roose](https://github.com/brendt)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

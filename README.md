# HDNET Code Standard

> HDNET code style and workflow standards for backend projects.

## Tools

- Rector
- PHP CS Fixer
- Captainhook
- PHPStan

## Installation

```bash
composer config repositories.repo-name vcs https://github.com/HDNET/standard
composer require hdnet/standard --dev
```

## Configuration (tbd.)

Via root composer.json extra section. Here a full example of the configuration options.

```php
    // ...
    "extra": {
        "standard": {
            "php-cs-fixer": [
                "riskyAllowed": false,
            ],
            "rector": [
                // tbd.
            ],
            "captainhook": [
                // tbd.
            ],
        }
    },
    // ...
```

## TODO:

- Migration of linter from https://github.com/HDNET/hdnet-standards
- Project analysis
- PHP 7.4 support for the package?

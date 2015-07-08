# Kong Provider for OAuth 2.0 Client

This package provides Kong OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Requirements

The following versions of PHP are supported.

* PHP 5.5
* PHP 5.6
* PHP 7.0
* HHVM

## Installation

Add the following to your `composer.json` file.

> **Note:** Once version 1.0 of the [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client) is released, you'll be able to install from composer without the `@dev` minimum stability flag.

```json
{
    "require": {
        "kong/kong-oauth2-php-provider": "~0.0@dev",
        "league/oauth2-client": "~1.0@dev"
    }
}
```

> **Note:** OAuth 2.0 Client v1.0 is still in dev mode so you'll need to require it explicitly in your require using the `@dev` minimum stability flag since [composer won't pull in a dev mode dependency of a dependency](https://getcomposer.org/doc/faqs/why-can%27t-composer-load-repositories-recursively.md).


## Usage

### Authorization Code Flow

See example/index.php

## License

The MIT License (MIT). Please see [License File](https://github.com/thephpleague/oauth2-facebook/blob/master/LICENSE) for more information.
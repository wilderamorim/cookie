# Cookie @ElePHPant

[![Maintainer](http://img.shields.io/badge/maintainer-@wilderamorim-blue.svg?style=flat-square)](https://twitter.com/WilderAmorim)
[![Source Code](http://img.shields.io/badge/source-wilderamorim/cookie-blue.svg?style=flat-square)](https://github.com/wilderamorim/cookie)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/elephpant/cookie.svg?style=flat-square)](https://packagist.org/packages/elephpant/cookie)
[![Latest Version](https://img.shields.io/github/release/wilderamorim/cookie.svg?style=flat-square)](https://github.com/wilderamorim/cookie/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/wilderamorim/cookie.svg?style=flat-square)](https://scrutinizer-ci.com/g/wilderamorim/cookie)
[![Quality Score](https://img.shields.io/scrutinizer/g/wilderamorim/cookie.svg?style=flat-square)](https://scrutinizer-ci.com/g/wilderamorim/cookie)
[![Total Downloads](https://img.shields.io/packagist/dt/elephpant/cookie.svg?style=flat-square)](https://packagist.org/packages/elephpant/cookie)

## Installation

### Composer (recommended)

Use [Composer](https://getcomposer.org) to install this library from Packagist:
[`elephpant/cookie`](https://packagist.org/packages/elephpant/cookie)

Run the following command from your project directory to add the dependency:

```sh
composer require elephpant/cookie "^2.0"
```

Alternatively, add the dependency directly to your `composer.json` file:

```json
"require": {
    "elephpant/cookie": "^2.0"
}
```

### Usage

```php
<?php
use ElePHPant\Cookie\Cookie\Cookie;

// default expiration: minutes
// default encryption: there is no encryption
$cookie = new Cookie();

// change expiration unit
$options = [
    'expiration' => 'days', // seconds, minutes, hours, days, weeks, months, years
];

// set Base64 encryption
$options = [
    'encryption' => \ElePHPant\Cookie\Strategies\Encryption\Base64EncryptionStrategy::class,
];

// set AES-256 encryption
$options = [
    'encryption' => \ElePHPant\Cookie\Strategies\Encryption\AES256EncryptionStrategy::class,
    'encrypt_key' => 'SET_YOUR_ENCRYPT_KEY_HERE', // required if using AES-256
];

// other optional parameters
$options['path'] = '/';
$options['domain'] = '';
$options['secure'] = false;
$options['httponly'] = false;

// SameSite
$options['samesite'] = 'None'; // must be 'None', 'Lax' or 'Strict'. If none requires secure true
$options['secure'] = true; // required if samesite is 'None'

$cookie = new Cookie($options);
```

##### Create Cookie:

```php
$str = 'john_doe';
$arr = ['name' => 'John Doe', 'email' => 'john@example.com', 'age' => 30,];

// name, value(s), expiration, ...
$cookie::set('username', $str, 20);
$cookie::set('user', $arr, 20);
```

##### Get Cookie(s):

```php
echo $cookie::get('username'); // john_doe


$arr = $cookie::get('user');
var_export($arr); // array ( 'name' => 'John Doe', 'email' => 'john@example.com', 'age' => 30, )
echo $arr['email']; // john@example.com


$all = $cookie::get();
var_export($all); // array ( 'username' => 'john_doe', 'user' => array ( 'name' => 'John Doe', 'email' => 'john@example.com', 'age' => 30, ), )


var_export($_COOKIE); // array ( 'username' => '9sV1OIHc7taGoafeXWjl+gcrJFpIpg8Hkqe4fdGRygI=', 'user' => 'rLrCW9eBvoPijA+bSuIIrqbWccbYJqk2aPK5RGMwiLNpMZw2nYrrU7A2Zmuk3CGt0XiXlXpcQQv7h40M/6jbYslrlsvTJXm3mtG0nyiRDCg=', )
```

##### Create if Doesn't Exist:

```php
$cookie::setDoesntHave('cookie_consent', true, 60);
```

##### Create if Doesn't Exist and Delete if it Exists:

```php
$cookie::setDoesntHave('toggle_sidebar', true, 60, true);
```

##### Remove:

```php
$cookie::destroy('user');
$cookie::destroy(); // all
```

##### Check if Exists:

```php
if ($cookie::has('food')) {
    echo 'The cookie exists.';
} else {
    echo 'The cookie does not exist.';
}
```

##### Check if Exists by Value:

```php
if ($cookie::has('username', $str)) {
    echo 'The cookie exists with the correct value.';
} else {
    echo 'The cookie does not exist or has a different value.';
}

if ($cookie::has('user', $arr)) {
    echo 'The cookie exists with the correct value.';
} else {
    echo 'The cookie does not exist or has a different value.';
}
```

## Contributing

No one ever has enough engineers, so we're very happy to accept contributions
via Pull Requests. For details, see [CONTRIBUTING](CONTRIBUTING.md)

## Credits

- [Wilder Amorim](https://github.com/wilderamorim) (Developer)
- [All Contributors](https://github.com/wilderamorim/cookie/contributors) (This Rock)

## License

The MIT License (MIT). Please see [License File](https://github.com/wilderamorim/cookie/blob/master/LICENSE) for more information.
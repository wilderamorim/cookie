# Cookie @ElePHPant

[![Maintainer](http://img.shields.io/badge/maintainer-@wilderamorim-blue.svg?style=flat-square)](https://twitter.com/WilderAmorim)
[![Source Code](http://img.shields.io/badge/source-wilderamorim/cookie-blue.svg?style=flat-square)](https://github.com/wilderamorim/cookie)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/elephpant/cookie.svg?style=flat-square)](https://packagist.org/packages/elephpant/cookie)
[![Latest Version](https://img.shields.io/github/release/wilderamorim/cookie.svg?style=flat-square)](https://github.com/wilderamorim/cookie/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/wilderamorim/cookie.svg?style=flat-square)](https://scrutinizer-ci.com/g/wilderamorim/cookie)
[![Quality Score](https://img.shields.io/scrutinizer/g/wilderamorim/cookie.svg?style=flat-square)](https://scrutinizer-ci.com/g/wilderamorim/cookie)
[![Total Downloads](https://img.shields.io/packagist/dt/elephpant/cookie.svg?style=flat-square)](https://packagist.org/packages/elephpant/cookie)

###### A simple and effective way to work with Cookies.

Um jeito simples e eficaz de trabalhar com Cookies.

### Highlights

- Simple installation (Instalação simples)
- Composer ready and PSR-2 compliant (Pronto para o composer e compatível com PSR-2)

## Installation

Cookie is available via Composer:

```bash
"elephpant/cookie": "1.0.*"
```

or run

```bash
composer require elephpant/cookie
```

## Documentation

###### For details on how to use, see a sample folder in the component directory. In it you will have an example of use for each class. It works like this:

Para mais detalhes sobre como usar, veja uma pasta de exemplo no diretório do componente. Nela terá um exemplo de uso para cada classe. Ele funciona assim:

##### Create Cookie:

```php
<?php
require __DIR__ . '/../vendor/autoload.php';
use ElePHPant\Cookie\Cookie;

//name, value, minutes, ...
Cookie::set('food', 'egg', 20);
```

##### Get Cookie Value:

```php
echo Cookie::get('food'); //egg
```

##### Create Value as Array:

```php
//name, values, minutes, ...
Cookie::set('users', [
    'name' => 'Amorim',
    'role' => 'Developer'
], 20);
```

##### Get Value as Array:

```php
//name, isArray...
echo Cookie::get('users', true)['role']; //Developer
```

##### Remove:

```php
Cookie::destroy('food');
```

##### Check if Exists:

```php
if (Cookie::has('food')) {
    echo 'exists';
} else {
    echo 'does not exist';
}
```

##### Check if Exists by Value:

```php
//name, value
if (Cookie::has('food', 'egg')) {
    echo 'the value is equal to egg';
} else {
    echo 'the value is different to egg';
}
```

##### Show All / Debug:

```php
Cookie::all();
```

## Contributing

Please see [CONTRIBUTING](https://github.com/wilderamorim/cookie/blob/master/CONTRIBUTING.md) for details.

## Support

###### Security: If you discover any security related issues, please email agencia@uebi.com.br instead of using the issue tracker.

Se você descobrir algum problema relacionado à segurança, envie um e-mail para agencia@uebi.com.br em vez de usar o rastreador de problemas.

Thank you

## Credits

- [Wilder Amorim](https://github.com/wilderamorim) (Developer)
- [Agência Uebi](https://www.uebi.com.br) (Team)
- [All Contributors](https://github.com/wilderamorim/cookie/contributors) (This Rock)

## License

The MIT License (MIT). Please see [License File](https://github.com/wilderamorim/cookie/blob/master/LICENSE) for more information.
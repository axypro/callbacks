# axy\callbacks: the callback extended format

[![Latest Stable Version](https://img.shields.io/packagist/v/axy/callbacks.svg?style=flat-square)](https://packagist.org/packages/axy/callbacks)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.4-8892BF.svg?style=flat-square)](https://php.net/)
[![Build Status](https://img.shields.io/travis/axypro/callbacks/master.svg?style=flat-square)](https://travis-ci.org/axypro/callbacks)
[![Coverage Status](https://coveralls.io/repos/axypro/callbacks/badge.svg?branch=master&service=github)](https://coveralls.io/github/axypro/callbacks?branch=master)
[![License](https://poser.pugx.org/axy/callbacks/license)](LICENSE)

* The library does not require any dependencies.
* Tested on PHP 5.4+, PHP 7, HHVM (on Linux).
* Install: `composer require axy/callbacks`.
* License: [MIT](LICENSE).

### Documentation

* [Callback format](doc/format.md)
* [Arguments binding](doc/args.md)
* [Context binding](doc/bind.md)
* [How to use](doc/Callback.md)

### Examples

```php
function sum($a, $b)
{
    return $a + $b;
}
```

Standard callback:
```php
$callback = new Callback('sum');

echo $callback(2, 2);
```

Binging arguments:
```php
$callback = new Callback('sum', [3]);

echo $callback(4); // 3 + 4 = 7
```

Binging context:
```php
class MyClass
{
    public function getEventHandler()
    {
        return new Callback([$this, 'onEvent'], ['click'], true);
    }

    private function onEvent($event)
    {
        echo 'Event '.$event.'!';
    }
}

$obj = new MyClass();
$handler = $obj->getEventHandler();

// click
$handler(); // "Event click!". Private method was called
```

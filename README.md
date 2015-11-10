# axy\callbacks: the callback extended format

 * GitHub: [axypro/callbacks](https://github.com/axypro/callbacks)
 * Composer: [axy/callbacks](https://packagist.org/packages/axy/callbacks)

PHP 5.4+

The library does not require any dependencies (except composer packages).

## Documentation

* [Callback format](doc/format.md)
* [Arguments binding](doc/args.md)
* [Context binding](doc/bind.md)
* [How to use](doc/Callback.md)

## Examples

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

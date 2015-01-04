# How to use

To work with extended callback format there is class `axy\callbacks\Callback`.

## Variant one

Use `Callback::call()` instead `call_user_func()`.

```php
use axy\callbacks\Callback;

$callback = ['class', 'method', [1, 2, 3]];

echo Callback::call($callback);
```

Format:

```php
Callback::call(callable $callback [, array $args]):mixed
```

## Variant two

If, however, require to use of `call_user_func()`, you can convert a custom callback to native format.

```php

$callback = ['class', 'method', [1, 2, 3]];

$callback = Callback::createNative($callback);

echo call_user_func($callback, 4);
```

Format:

```php
Callback::createNative(callable $callback [, bool $forceObject]):callable
```

* Extended format convert to an instance of Callback class (which has `__invoke`).
* Native format remains unchanged.
* If you set argument `$forceObject` to `TRUE` then always return an object.

## Callback-object

You can create a Callback-object directly:

```php
$callback = new Callback('fgets', [$fp]);

echo $callback();
```

The constructor format:

```php
__constructor(callable $native [, array $args [, bool $bindContext])
```

* `$native`: callback in native format
* `$arg`: bound arguments
* `$bindContext`: the flag for bind context

Method `isCallable():boolean` tells whether you can call this callback.

```php
$callback = new Callback('unknownFunction');

echo $callback->isCallable(); // FALSE: unknown function
```

## Exceptions

The exceptions classes, which throws the library is located in the namespace `axy\callbacks\errors`.

#### `InvalidFormat`

A callback has an invalid format.

* `args` is not array.
* Set `method`, but the `class` or `object` is not specified.
* The use of `bind` for global function.
* etc.

#### `NotCallable`

A callback is valid, but cannot be executed.
For example, specified the name of a nonexistent function.


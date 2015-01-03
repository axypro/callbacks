# Callback format

Callback format which provides by the library is backward compatible with the standard format.

Variants of [standard format](http://php.net/manual/en/language.types.callable.php):

* string `"functionName"`
* array `[$object, "methodName"]`
* array `["ClassName", "staticMethodName"]`
* string `"ClassName::staticMethodName"`
* an object with a method `__invoke`
* [Closure](http://php.net/manual/en/class.closure.php)

All of these variants are supported in the library.

## The numeric array

[Bound arguments](args.md) are specified in the element with index 2 as numeric array.

* `[$object, "methodName", $args]`: $object->methodName() with arguments from $args.
* `["ClassName", "staticMethodName", $args]`
* `["ClassName::staticMethodName", null, $args]` - similar to the previous
* `[null, "funcName", $args]` - global function (without class)
* `[$object, null, $args]` - call the object as function (`__invoke()`)
* `[null, $closure, $args]`

Example:

```php
$callback = [$object, 'methodName', [1, 2]];

Callback::call($callback, [3, 4]); // $object->methodName(1, 2, 3, 4)
```

The optional flag for [bind context](bind.md) are specified in the element with index 3.
 
* `[$object, "methodName", $args, true]`
* `[$object, "methodName", null, true]` - bind context without arguments
* ...

```php
$callback = [$object, 'privateMethodName', [1, 2], true];

Callback::call($callback, [3, 4]); // $object->privateMethodName(1, 2, 3, 4)
```

## Full format

The associative array.
All fields are optional.

* `function` - a global function name or a closure.
* `object` - an object. Needs `method` (or `__invoke` by default)
* `class` - a class name. Needs `method` for static method name.
* `method` - a method name. Needs `object` or `class`.
* `args` - a list of arguments for binding (numeric array).
* `bind` - a bind flag (boolean, FALSE by default).

```php
$callback = [
    'class' => 'MyClass',
    'method' => 'privateStaticMethodName',
    'bind' => true,
];
```

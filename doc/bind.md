# Context binding

For example:

```php
class Events
{
    public static function addListener($listener)
    {
        self::$listener = $listener;
    }
    
    public static function fire()
    {
        call_user_func(self::$listener);
    }
    
    private static $listener;
}

class MyClass
{
    public function __construct()
    {
        Events::addListener([$this, 'onEvent']);
    }
    
    private function onEvent()
    {
        echo 'Event!';
    }
}

$myInstance = new MyClass();

Events::fire();
```

Error:

```
call_user_func() expects parameter 1 to be a valid callback, cannot access private method MyClass::onEvent()
```

And this example with `axy\callbacks` and `bind`:

```php
class Events
{
    public static function addListener($listener)
    {
        self::$listener = $listener;
    }

    public static function fire()
    {
        Callback::call(self::$listener);
    }

    private static $listener;
}

class MyClass
{
    public function __construct()
    {
        Events::addListener(['object' => $this, 'method' => 'onEvent', 'bind' => true]);
    }

    private function onEvent()
    {
        echo 'Event!';
    }
}

$myInstance = new MyClass();

Events::fire();
```

Success:
```
Event!
```

Bind requires a lot of resources, use it only when necessary

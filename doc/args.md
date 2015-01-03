# Arguments binding

Bounded arguments are inserted into the beginning of the call.

```php
/* $callback associated with arguments [1, 2] */
$callback(3, 4); // call (1, 2, 3, 4)
```

Example 1:

```php
function mul($x, $y) {
    return $x * $y;
}

$mul3 = new Callback('mul', [3]);

$mul3(5); // 3 * 5
$mul3(10); // 3 * 10
```

Example 2:

```php
$fp = fopen('file.txt', "rt");

$getLineFromFile = ["fgets", null, [$fp]];

echo Callback::call($getLineFromFile); // first line
echo Callback::call($getLineFromFile); // second line
```

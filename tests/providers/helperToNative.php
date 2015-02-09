<?php

use axy\callbacks\tests\tst\CallB;

$instance = CallB::createInstance();

return [
    [
        'is_array',
        [
            'native' => 'is_array',
            'args' => [],
            'bind' => false,
        ],
    ],
    [
        [$instance, 'method'],
        [
            'native' => [$instance, 'method'],
            'args' => [],
            'bind' => false,
        ],
    ],
    [
        ['axy\callbacks\tests\tst\CallB', 'mStatic'],
        [
            'native' => ['axy\callbacks\tests\tst\CallB', 'mStatic'],
            'args' => [],
            'bind' => false,
        ],
    ],
    [
        'axy\callbacks\tests\tst\CallB::mStatic',
        [
            'native' => 'axy\callbacks\tests\tst\CallB::mStatic',
            'args' => [],
            'bind' => false,
        ],
    ],
    [
        $instance,
        [
            'native' => $instance,
            'args' => [],
            'bind' => false,
        ],
    ],
    [
        CallB::getClosure(),
        [
            'native' => CallB::getClosure(),
            'args' => [],
            'bind' => false,
        ],
    ],
    [
        [$instance, 'method', [1, 2, 3]],
        [
            'native' => [$instance, 'method'],
            'args' => [1, 2, 3],
            'bind' => false,
        ],
    ],
    [
        ['axy\callbacks\tests\tst\CallB', 'mStatic', [4, 5]],
        [
            'native' => ['axy\callbacks\tests\tst\CallB', 'mStatic'],
            'args' => [4, 5],
            'bind' => false,
        ],
    ],
    [
        ['axy\callbacks\tests\tst\CallB', 'mStatic', [4, 5], true],
        [
            'native' => ['axy\callbacks\tests\tst\CallB', 'mStatic'],
            'args' => [4, 5],
            'bind' => true,
        ],
    ],
    [
        ['axy\callbacks\tests\tst\CallB::mStatic', null, [2]],
        [
            'native' => 'axy\callbacks\tests\tst\CallB::mStatic',
            'args' => [2],
            'bind' => false,
        ],
    ],
    [
        [null, 'is_array', [1, 2]],
        [
            'native' => 'is_array',
            'args' => [1, 2],
            'bind' => false,
        ],
    ],
    [
        [null, 'is_array', [1, 2], false],
        [
            'native' => 'is_array',
            'args' => [1, 2],
            'bind' => false,
        ],
    ],
    [
        [null, 'is_array', [1, 2], true],
        null,
    ],
    [
        [$instance, null, [1, 2]],
        [
            'native' => $instance,
            'args' => [1, 2],
            'bind' => false,
        ],
    ],
    [
        [null, CallB::getClosure(), [1, 2]],
        [
            'native' => CallB::getClosure(),
            'args' => [1, 2],
            'bind' => false,
        ],
    ],
    [
        [$instance, 'method', null],
        [
            'native' => [$instance, 'method'],
            'args' => [],
            'bind' => false,
        ],
    ],
    [
        [$instance, 'method', 2],
        null,
    ],
    [
        [
            'function' => 'is_array',
        ],
        [
            'native' => 'is_array',
            'args' => [],
            'bind' => false,
        ],
    ],
    [
        [
            'function' => 'is_array',
            'bind' => true,
        ],
        null,
    ],
    [
        [
            'function' => 'is_array',
            'args' => [3, 4],
        ],
        [
            'native' => 'is_array',
            'args' => [3, 4],
            'bind' => false,
        ],
    ],
    [
        [
            'function' => 'is_array',
            'args' => 2,
        ],
        null,
    ],
    [
        [
            'object' => $instance,
            'args' => [2],
        ],
        [
            'native' => $instance,
            'args' => [2],
            'bind' => false,
        ],
    ],
    [
        [
            'object' => $instance,
            'method' => 'method',
            'args' => [2],
        ],
        [
            'native' => [$instance, 'method'],
            'args' => [2],
            'bind' => false,
        ],
    ],
    [
        [
            'object' => $instance,
            'method' => 'method',
            'args' => [2],
            'bind' => false,
        ],
        [
            'native' => [$instance, 'method'],
            'args' => [2],
            'bind' => false,
        ],
    ],
    [
        [
            'object' => $instance,
            'method' => 'method',
            'args' => [2],
            'bind' => true,
        ],
        [
            'native' => [$instance, 'method'],
            'args' => [2],
            'bind' => true,
        ],
    ],
    [
        [
            'class' => 'axy\callbacks\tests\tst\CallB',
            'method' => 'mStatic',
            'args' => [2],
        ],
        [
            'native' => ['axy\callbacks\tests\tst\CallB', 'mStatic'],
            'args' => [2],
            'bind' => false,
        ],
    ],
    [
        [
            'class' => 'axy\callbacks\tests\tst\CallB',
            'args' => [2],
        ],
        null,
    ],
    [
        [
        ],
        null,
    ],
    [
        ['unknown'],
        null,
    ],
];

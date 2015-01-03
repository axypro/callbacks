<?php

use axy\callbacks\tests\nstst\Callb;

$instance = Callb::createInstance();

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
        ['axy\callbacks\tests\nstst\Callb', 'mstatic'],
        [
            'native' => ['axy\callbacks\tests\nstst\Callb', 'mstatic'],
            'args' => [],
            'bind' => false,
        ],
    ],
    [
        'axy\callbacks\tests\nstst\Callb::mstatic',
        [
            'native' => 'axy\callbacks\tests\nstst\Callb::mstatic',
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
        Callb::getClosure(),
        [
            'native' => Callb::getClosure(),
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
        ['axy\callbacks\tests\nstst\Callb', 'mstatic', [4, 5]],
        [
            'native' => ['axy\callbacks\tests\nstst\Callb', 'mstatic'],
            'args' => [4, 5],
            'bind' => false,
        ],
    ],
    [
        ['axy\callbacks\tests\nstst\Callb', 'mstatic', [4, 5], true],
        [
            'native' => ['axy\callbacks\tests\nstst\Callb', 'mstatic'],
            'args' => [4, 5],
            'bind' => true,
        ],
    ],
    [
        ['axy\callbacks\tests\nstst\Callb::mstatic', null, [2]],
        [
            'native' => 'axy\callbacks\tests\nstst\Callb::mstatic',
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
        [null, Callb::getClosure(), [1, 2]],
        [
            'native' => Callb::getClosure(),
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
            'class' => 'axy\callbacks\tests\nstst\Callb',
            'method' => 'mstatic',
            'args' => [2],
        ],
        [
            'native' => ['axy\callbacks\tests\nstst\Callb', 'mstatic'],
            'args' => [2],
            'bind' => false,
        ],
    ],
    [
        [
            'class' => 'axy\callbacks\tests\nstst\Callb',
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

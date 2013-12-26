<?php
/**
 * @package axy\callbacks
 */

namespace axy\callbacks\tests;

use axy\callbacks\Helper;
use axy\callbacks\tests\nstst\Callb;

/**
 * @coversDefaultClass axy\callbacks\Helper
 */
class HelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::toNative
     * @dataProvider providerToNative
     * @param mixed $callback
     * @param array $expected (null - exception)
     */
    public function testToNative($callback, $expected)
    {
        if ($expected === null) {
            $this->setExpectedException('axy\callbacks\errors\InvalidFormat');
        }
        $actual = Helper::toNative($callback);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function providerToNative()
    {
        $instance = Callb::createInstance();
        return [
            [
                'is_array',
                [
                    'native' => 'is_array',
                    'args' => [],
                ],
            ],
            [
                [$instance, 'method'],
                [
                    'native' => [$instance, 'method'],
                    'args' => [],
                ],
            ],
            [
                ['axy\callbacks\tests\nstst\Callb', 'mstatic'],
                [
                    'native' => ['axy\callbacks\tests\nstst\Callb', 'mstatic'],
                    'args' => [],
                ],
            ],
            [
                'axy\callbacks\tests\nstst\Callb::mstatic',
                [
                    'native' => 'axy\callbacks\tests\nstst\Callb::mstatic',
                    'args' => [],
                ],
            ],
            [
                $instance,
                [
                    'native' => $instance,
                    'args' => [],
                ],
            ],
            [
                Callb::getClosure(),
                [
                    'native' => Callb::getClosure(),
                    'args' => [],
                ],
            ],
            [
                [$instance, 'method', [1, 2, 3]],
                [
                    'native' => [$instance, 'method'],
                    'args' => [1, 2, 3],
                ],
            ],
            [
                ['axy\callbacks\tests\nstst\Callb', 'mstatic', [4, 5]],
                [
                    'native' => ['axy\callbacks\tests\nstst\Callb', 'mstatic'],
                    'args' => [4, 5],
                ],
            ],
            [
                ['axy\callbacks\tests\nstst\Callb::mstatic', null, [2]],
                [
                    'native' => 'axy\callbacks\tests\nstst\Callb::mstatic',
                    'args' => [2],
                ],
            ],
            [
                [null, 'is_array', [1, 2]],
                [
                    'native' => 'is_array',
                    'args' => [1, 2],
                ],
            ],
            [
                [$instance, null, [1, 2]],
                [
                    'native' => $instance,
                    'args' => [1, 2],
                ],
            ],
            [
                [null, Callb::getClosure(), [1, 2]],
                [
                    'native' => Callb::getClosure(),
                    'args' => [1, 2],
                ],
            ],
            [
                [$instance, 'method', null],
                [
                    'native' => [$instance, 'method'],
                    'args' => [],
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
                ],
            ],
            [
                [
                    'function' => 'is_array',
                    'args' => [3, 4],
                ],
                [
                    'native' => 'is_array',
                    'args' => [3, 4],
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
    }
}
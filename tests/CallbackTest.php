<?php
/**
 * @package axy\callbacks
 */

namespace axy\callbacks\tests;

use axy\callbacks\Callback;
use axy\callbacks\tests\nstst\Callb;

/**
 * @coversDefaultClass axy\callbacks\Callback
 */
class HelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::call
     * @dataProvider providerCall
     * @param mixed $callback
     * @param array $expected
     * @param string $exception [optional]
     */
    public function testCall($callback, $expected, $expectedArgs, $exception = null)
    {
        if ($exception) {
            $this->setExpectedException('axy\callbacks\errors\\'.$exception);
        }
        $result = Callback::call($callback, [1, 2]);
        $this->assertEquals($expected, $result);
        if ($expectedArgs !== null) {
            $this->assertEquals($expectedArgs, Callb::$args);
        }
    }

    /**
     * @return array
     */
    public function providerCall()
    {
        $instance = Callb::createInstance();
        return [
            [
                'max',
                2,
                null,
            ],
            [
                [null, 'max', [3, 4]],
                4,
                null,
            ],
            [
                [$instance, 'method'],
                'method',
                [1, 2],
            ],
            [
                [$instance, 'method', [3, 4]],
                'method',
                [3, 4, 1, 2],
            ],
            [
                [$instance, 'method', 3],
                null,
                null,
                'InvalidFormat',
            ],
            [
                [$instance, 'unkmethod', [3, 4]],
                null,
                null,
                'NotCallable',
            ],
            [
                [$instance, null, [5]],
                'invoke',
                [5, 1, 2],
            ],
            [
                ['axy\callbacks\tests\nstst\Callb', 'mstatic', [10, 11]],
                'static',
                [10, 11, 1, 2],
            ],
            [
                ['axy\callbacks\tests\nstst\Callb', null, [10, 11]],
                null,
                null,
                'NotCallable',
            ],
            [
                ['axy\callbacks\tests\nstst\Callb::mstatic', null, [1]],
                'static',
                [1, 1, 2],
            ],
            [
                Callb::getClosure(),
                'closure',
                [1, 2],
            ],
            [
                [null, Callb::getClosure(), [4, 5]],
                'closure',
                [4, 5, 1, 2],
            ],
            [
                [null, Callb::getClosure(), null],
                'closure',
                [1, 2],
            ],
            [
                [
                    'object' => $instance,
                    'method' => 'method',
                ],
                'method',
                [1, 2],
            ],
            [
                [
                    'object' => $instance,
                    'args' => [7],
                ],
                'invoke',
                [7, 1, 2],
            ],
            [
                [
                    'object' => $instance,
                    'args' => 7,
                ],
                null,
                null,
                'InvalidFormat',
            ],
        ];
    }
}

<?php
/**
 * @package axy\callbacks
 */

namespace axy\callbacks\tests;

use axy\callbacks\Callback;
use axy\callbacks\tests\nstst\Callb;
use axy\callbacks\tests\nstst\Bind;

/**
 * coversDefaultClass axy\callbacks\Callback
 */
class CallbackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::call
     * @dataProvider providerCall
     * @param mixed $callback
     * @param array $expected
     * @param array $expectedArgs
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

    /**
     * covers ::__construct
     * covers ::__invoke
     */
    public function testInvoke()
    {
        $native = [Callb::createInstance(), 'method'];
        $callback = new Callback($native, [1, 2]);
        $this->assertSame('method', $callback(3, 4));
        $this->assertEquals([1, 2, 3, 4], Callb::$args);
    }

    /**
     * covers ::isCallable
     * covers ::__invoke
     */
    public function testIsCallable()
    {
        $native1 = [Callb::createInstance(), 'method'];
        $callback1 = new Callback($native1, [1, 2]);
        $this->assertTrue($callback1->isCallable());
        $native2 = [Callb::createInstance(), 'unkmethod'];
        $callback2 = new Callback($native2, [1, 2]);
        $this->assertFalse($callback2->isCallable());
        $this->setExpectedException('axy\callbacks\errors\NotCallable');
        $callback2(3, 4);
    }

    /**
     * covers ::createNative
     */
    public function testCreateNative()
    {
        $callback1 = [Callb::createInstance(), 'method', [1, 2]];
        $native1 = Callback::createNative($callback1);
        $this->assertInstanceOf('axy\callbacks\Callback', $native1);
        $this->assertSame('method', $native1(3));
        $this->assertEquals([1, 2, 3], Callb::$args);
        $callback2 = [Callb::createInstance(), 'method'];
        $native2 = Callback::createNative($callback2);
        $this->assertEquals($callback2, $native2);
        $this->assertSame('method', $native2(3));
        $this->assertEquals([3], Callb::$args);
        $native3 = Callback::createNative($callback2, true);
        $this->assertInstanceOf('axy\callbacks\Callback', $native3);
        $this->assertSame('method', $native3(4));
        $this->assertEquals([4], Callb::$args);
    }

    /**
     * covers ::__construct
     * covers ::__invoke
     */
    public function testBindContextInstance()
    {
        $instance = new Bind(5);
        $callback = new Callback([$instance, 'setX'], [2], true);
        $this->assertSame(5, $callback(10));
        $this->assertSame(12, $instance->getX());
        $this->setExpectedException('axy\callbacks\errors\InvalidFormat');
        return new Callback('is_array', [2], true);
    }

    /**
     * covers ::__construct
     * covers ::__invoke
     */
    public function testBindContextStatic()
    {
        $callback = new Callback(['axy\callbacks\tests\nstst\Bind', 'setS'], [5], true);
        $s = Bind::getS();
        $this->assertSame($s, $callback(11));
        $this->assertSame(16, Bind::getS());
        $this->setExpectedException('axy\callbacks\errors\InvalidFormat');
        return new Callback([1, 'setS'], [2], true);
    }

    public function testCallBindContextInstance()
    {
        $instance = new Bind(-3);
        $callback = [
            'object' => $instance,
            'method' => 'setX',
            'args' => [7],
            'bind' => true,
        ];
        $this->assertSame(-3, Callback::call($callback, [3]));
        $this->assertSame(10, $instance->getX());
        unset($callback['object']);
        $this->setExpectedException('axy\callbacks\errors\InvalidFormat');
        Callback::call($callback, [3]);
    }

    public function testCallBindStatic()
    {
        $instance = new Bind();
        $callback = [
            'class' => 'axy\callbacks\tests\nstst\Bind',
            'method' => 'setS',
            'args' => [7],
            'bind' => true,
        ];
        $s = Bind::getS();
        $this->assertSame($s, Callback::call($callback, [$s + 3]));
        $this->assertSame($s + 10, $instance->getS());
        unset($callback['class']);
        $this->setExpectedException('axy\callbacks\errors\InvalidFormat');
        Callback::call($callback, [3]);
    }
}

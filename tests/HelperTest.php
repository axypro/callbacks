<?php
/**
 * @package axy\callbacks
 */

namespace axy\callbacks\tests;

use axy\callbacks\Helper;
use axy\callbacks\tests\nstst\Bind;

/**
 * coversDefaultClass axy\callbacks\Helper
 */
class HelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::toNative
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
        return include __DIR__.'/providers/helperToNative.php';
    }

    /**
     * covers ::bindInstance
     */
    public function testBindInstance()
    {
        $instance = new Bind(5);
        $this->assertSame(5, $instance->getX());
        $callback1 = Helper::bindInstance($instance, 'setX');
        $this->assertSame(5, \call_user_func($callback1, 10));
        $this->assertSame(10, $instance->getX());
        $this->assertSame(10, \call_user_func($callback1, 15));
        $this->assertSame(15, $instance->getX());
        $callback2 = Helper::bindInstance($instance, 'setX', [3]);
        $this->assertSame(15, \call_user_func($callback2, 20));
        $this->assertSame(23, $instance->getX());
        $this->assertSame(23, \call_user_func($callback2, 25));
        $this->assertSame(28, $instance->getX());
    }

    /**
     * covers ::bindStatic
     */
    public function testBindStatic()
    {
        $s = Bind::getS();
        $callback1 = Helper::bindStatic('axy\callbacks\tests\nstst\Bind', 'setS');
        $this->assertSame($s, \call_user_func($callback1, $s + 1));
        $s++;
        $this->assertSame($s, Bind::getS());
        $this->assertSame($s, \call_user_func($callback1, $s + 2));
        $s += 2;
        $this->assertSame($s, Bind::getS());
        $callback2 = Helper::bindStatic('axy\callbacks\tests\nstst\Bind', 'setS', [4]);
        $this->assertSame($s, \call_user_func($callback2, 20));
        $this->assertSame(24, Bind::getS());
        $this->assertSame(24, \call_user_func($callback2, 25));
        $this->assertSame(29, Bind::getS());
    }
}

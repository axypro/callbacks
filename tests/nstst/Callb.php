<?php
/**
 * @package axy\callbacks
 */

namespace axy\callbacks\tests\nstst;

class Callb
{
    public static $call;

    public static $args;

    /**
     * @return \axy\errors\tests\nstst\Callb
     */
    public static function createInstance()
    {
        return new self();
    }

    public static function mstatic()
    {
        self::$call = 'static';
        self::$args = func_get_args();
        return self::$call;
    }

    public function method()
    {
        self::$call = 'method';
        self::$args = func_get_args();
        return self::$call;
    }

    public function __invoke()
    {
        self::$call = 'invoke';
        self::$args = func_get_args();
        return self::$call;
    }

    /**
     * @return \Closure
     */
    public static function getClosure()
    {
        if (!self::$closure) {
            self::$closure = function () {
                Callb::$call = 'closure';
                Callb::$args = \func_get_args();
                return Callb::$call;
            };
        }
        return self::$closure;
    }

    private static $closure;
}

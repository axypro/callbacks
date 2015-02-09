<?php
/**
 * @package axy\callbacks
 */

namespace axy\callbacks\tests\tst;

class CallB
{
    public static $call;

    public static $args;

    /**
     * @return \axy\callbacks\tests\tst\CallB
     */
    public static function createInstance()
    {
        return new self();
    }

    public static function mStatic()
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
                CallB::$call = 'closure';
                CallB::$args = \func_get_args();
                return CallB::$call;
            };
        }
        return self::$closure;
    }

    private static $closure;
}

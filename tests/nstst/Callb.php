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
        self::$args = \func_get_args();
    }

    public function method()
    {
        self::$method = 'method';
        self::$args = \func_get_args();
    }

    public function __invoke()
    {
        self::$method = 'invoke';
        self::$args = \func_get_args();
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
            };
        }
        return self::$closure;
    }

    private static $closure;
}

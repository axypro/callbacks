<?php
/**
 * @package axy\callbacks
 */

namespace axy\callbacks\tests\nstst;

/**
 * The class to test the binding context
 */
class Bind
{
    /**
     * @param int $x [optional]
     */
    public function __construct($x = 5)
    {
        $this->setX($x);
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public static function getS()
    {
        return self::$s;
    }

    /**
     * @param int $x
     * @param int $d [optional]
     * @return int
     */
    private function setX($x, $d = 0)
    {
        $r = $this->x;
        $this->x = $x + $d;
        return $r;
    }

    /**
     * @param int $s
     * @param int $d [optional]
     * @return int
     */
    private static function setS($s, $d = 0)
    {
        $r = self::$s;
        self::$s = $s;
        return $r;
    }

    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private static $s = 10;
}

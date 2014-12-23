<?php
/**
 * @package axy\callbacks
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\callbacks\errors;

use axy\errors\InvalidConfig;

/**
 * Invalid format of the callback
 */
class InvalidFormat extends InvalidConfig implements Error
{
    /**
     * The constructor
     *
     * @param string $errmsg [optional]
     *        the error message
     * @param \Exception $previous [optional]
     * @param mixed $thrower [optional]
     */
    public function __construct($errmsg = null, \Exception $previous = null, $thrower = null)
    {
        parent::__construct('Callback', $errmsg, 0, $previous, $thrower);
    }
}

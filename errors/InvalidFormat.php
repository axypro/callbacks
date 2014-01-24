<?php
/**
 * @package axy\callbacks
 */

namespace axy\callbacks\errors;

/**
 * Invalid format of a callback
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class InvalidFormat extends \axy\errors\InvalidConfig implements Error
{
    /**
     * Constructor
     *
     * @param string $errmsg [optional]
     * @param \Exception $previous [optional]
     * @param mixed $thrower [optional]
     */
    public function __construct($errmsg = null, \Exception $previous = null, $thrower = null)
    {
        parent::__construct('Callback', $errmsg, 0, $previous, $thrower);
    }
}

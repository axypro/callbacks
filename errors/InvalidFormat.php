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
     * @param string $errorMessage [optional]
     *        the error message
     * @param \Exception $previous [optional]
     * @param mixed $thrower [optional]
     */
    public function __construct($errorMessage = null, \Exception $previous = null, $thrower = null)
    {
        parent::__construct('Callback', $errorMessage, 0, $previous, $thrower);
    }
}

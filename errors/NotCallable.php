<?php
/**
 * @package axy\callbacks
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\callbacks\errors;

use \axy\errors\Logic;

/**
 * The callback is not callable
 */
class NotCallable extends Logic implements Error
{
    /**
     * {@inheritdoc}
     */
    protected $defaultMessage = 'The callback is not callable"';
}

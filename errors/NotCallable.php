<?php
/**
 * @package axy\callbacks
 */

namespace axy\callbacks\errors;

use \axy\errors\Logic;

/**
 * The callback is not callable
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class NotCallable extends Logic implements Error
{
    /**
     * {@inheritdoc}
     */
    protected $defaultMessage = 'The callback is not callable"';
}

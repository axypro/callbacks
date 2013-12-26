<?php
/**
 * @package axy\callbacks
 */

namespace axy\callbacks\errors;

/**
 * The callback is not callable
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class NotCallable extends \axy\errors\Logic implements Error
{
    /**
     * {@inheritdoc}
     */
    protected $defaultMessage = 'The callback is not callable"';
}

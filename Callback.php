<?php
/**
 * @package axy\callbacks
 */

namespace axy\callbacks;

/**
 * The callback extended format
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class Callback
{
    /**
     * Call a callback
     *
     * @param mixed $callback
     *        a callback in the exntended format
     * @param array $args [optional]
     *        an arguments list of the call
     * @return mixed
     *         a result of call
     * @throws \axy\callbacks\errors\InvalidFormat
     *         invalid format of the callback
     * @throws \axy\callbacks\errors\NotCallable
     *         the callback is not callable
     */
    public static function call($callback, array $args = null)
    {
        $callback = Helper::toNative($callback);
        $args = \array_merge($callback['args'], $args ?: []);
        if (!\is_callable($callback['native'], false)) {
            throw new errors\NotCallable();
        }
        return \call_user_func_array($callback['native'], $args);
    }
}

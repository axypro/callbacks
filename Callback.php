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
     *        a callback in the extended format
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

    /**
     * Constructor
     *
     * @param mixed $native
     *        a callback in the native format
     * @param array $args
     *        a list of bound arguments
     */
    public function __construct($native, array $args = null)
    {
        $this->native = $native;
        $this->args = $args;
    }

    /**
     * Call the callback
     *
     * @return mixed
     * @throws \axy\callbacks\errors\NotCallable
     */
    public function __invoke()
    {
        if (!$this->isCallable()) {
            throw new errors\NotCallable();
        }
        $args = \func_get_args();
        if (!empty($this->args)) {
            $args = \array_merge($this->args, $args);
        }
        return \call_user_func_array($this->native, $args);
    }

    /**
     * Check if the callbask is callable
     *
     * @return boolean
     */
    public function isCallable()
    {
        return \is_callable($this->native, false);
    }

    /**
     * @var mixed
     */
    private $native;

    /**
     * @var array
     */
    private $args;
}

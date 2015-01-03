<?php
/**
 * @package axy\callbacks
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\callbacks;

use axy\callbacks\errors\InvalidFormat;
use axy\callbacks\errors\NotCallable;

/**
 * The callback extended format
 */
class Callback
{
    /**
     * Executes a callback
     *
     * @param mixed $callback
     *        a callback in the extended format
     * @param array $args [optional]
     *        an argument list of the call
     * @return mixed
     *         the result of the call
     * @throws \axy\callbacks\errors\InvalidFormat
     *         invalid format of the callback
     * @throws \axy\callbacks\errors\NotCallable
     *         the callback is not callable
     */
    public static function call($callback, array $args = null)
    {
        $callback = Helper::toNative($callback);
        if ($callback['bind']) {
            $native = $callback['native'];
            $first = $native[0];
            if (is_object($first)) {
                $callback = Helper::bindInstance($first, $native[1], $callback['args']);
            } elseif (is_string($first)) {
                $callback = Helper::bindStatic($first, $native[1], $callback['args']);
            } else {
                throw new InvalidFormat('Invalid callback for bind context');
            }
        } else {
            $args = array_merge($callback['args'], $args ?: []);
            $callback = $callback['native'];
            if (!is_callable($callback, false)) {
                throw new NotCallable();
            }
        }
        return call_user_func_array($callback, $args);
    }

    /**
     * Creates a native callback
     *
     * @param mixed $callback
     *        an extended callback
     * @param boolean $forceObj [optional]
     *        create a Callback instance in any case
     * @return \axy\callbacks\Callback
     *         a callback in native format
     * @throws \axy\callbacks\errors\InvalidFormat
     *         invalid format of the callback
     */
    public static function createNative($callback, $forceObj = false)
    {
        $callback = Helper::toNative($callback);
        if (empty($callback['args']) && (!$forceObj)) {
            return $callback['native'];
        }
        return new self($callback['native'], $callback['args']);
    }

    /**
     * The constructor
     *
     * @param mixed $native
     *        a callback in the native format
     * @param array $args [optional]
     *        a list of bound arguments
     * @param boolean $bindContext [optional]
     * @throws \axy\callbacks\errors\InvalidFormat
     */
    public function __construct($native, array $args = null, $bindContext = false)
    {
        $this->native = $native;
        $this->args = $args;
        if ($bindContext) {
            if (!is_array($native)) {
                throw new InvalidFormat('Invalid callback for bind context');
            }
            $first = $native[0];
            if (\is_object($first)) {
                $this->bound = Helper::bindInstance($first, $native[1], $args);
            } elseif (\is_string($first)) {
                $this->bound = Helper::bindStatic($first, $native[1], $args);
            } else {
                throw new InvalidFormat('Invalid callback for bind context');
            }
            $this->callable = true;
        }
    }

    /**
     * Executes the callback
     *
     * @return mixed
     * @throws \axy\callbacks\errors\NotCallable
     */
    public function __invoke()
    {
        if ($this->bound) {
            return call_user_func_array($this->bound, func_get_args());
        }
        if (!$this->isCallable()) {
            throw new NotCallable();
        }
        $args = func_get_args();
        if (!empty($this->args)) {
            $args = array_merge($this->args, $args);
        }
        return call_user_func_array($this->native, $args);
    }

    /**
     * Checks if the callback is callable
     *
     * @return boolean
     */
    public function isCallable()
    {
        if ($this->callable === null) {
            $this->callable = is_callable($this->native, false);
        }
        return $this->callable;
    }

    /**
     * @var mixed
     */
    private $native;

    /**
     * @var array
     */
    private $args;

    /**
     * @var \Closure
     */
    private $bound;

    /**
     * @var boolean
     */
    private $callable;
}

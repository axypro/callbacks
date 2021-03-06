<?php
/**
 * @package axy\callbacks
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\callbacks;

use axy\callbacks\errors\InvalidFormat;

/**
 * The helper for work with the callback format
 */
class Helper
{
    /**
     * Separates a native callback and bound arguments
     *
     * @param mixed $callback
     *        a callback in the extended format
     * @return array
     *         [native => ..., args => array]
     * @throws \axy\callbacks\errors\InvalidFormat
     *         the callback has invalid format
     */
    public static function toNative($callback)
    {
        if (!is_array($callback)) {
            return self::getNative($callback);
        }
        if (!array_key_exists('0', $callback)) {
            return self::getFromDict($callback);
        }
        if (!array_key_exists(2, $callback)) {
            return self::getNative($callback);
        }
        return self::getFromList($callback);
    }

    /**
     * Binds an instance with its method
     *
     * @param object $instance
     * @param string $methodName
     * @param array $args [optional]
     * @return \Closure
     */
    public static function bindInstance($instance, $methodName, $args = null)
    {
        $helper = new self();
        return $helper->createClosure($methodName, $args)->bindTo($instance, get_class($instance));
    }

    /**
     * Binds a class with its static method
     *
     * @param string $className
     * @param string $methodName
     * @param array $args [optional]
     * @return \Closure
     */
    public static function bindStatic($className, $methodName, $args = null)
    {
        if (empty($args)) {
            $args = null;
        }
        $native = [$className, $methodName];
        $callback = function () use ($native, $args) {
            $a = func_get_args();
            if ($args !== null) {
                $a = array_merge($a, $args);
            }
            return call_user_func_array($native, $a);
        };
        return $callback->bindTo(null, $className);
    }

    /**
     * @param mixed $callback
     * @return array
     * @throws \axy\callbacks\errors\InvalidFormat
     */
    private static function getFromList($callback)
    {
        $bind = isset($callback[3]) ? (bool)$callback[3] : false;
        if (!isset($callback[1])) {
            return self::getNative($callback[0], $callback[2], $bind);
        }
        if ($callback[0] === null) {
            return self::getNative($callback[1], $callback[2], $bind);
        }
        return self::getNative([$callback[0], $callback[1]], $callback[2], $bind);
    }

    /**
     * @param mixed $callback
     * @return array
     * @throws \axy\callbacks\errors\InvalidFormat
     */
    private static function getFromDict($callback)
    {
        $args = isset($callback['args']) ? $callback['args'] : [];
        $bind = isset($callback['bind']) ? (bool)$callback['bind'] : false;
        if (isset($callback['function'])) {
            $result = self::getNative($callback['function'], $args, $bind);
        } elseif (isset($callback['object'])) {
            $result = self::getFromDictByObject($callback, $args, $bind);
        } elseif (isset($callback['class'])) {
            $result = self::getFromDictByClass($callback, $args, $bind);
        } else {
            throw new InvalidFormat();
        }
        return $result;
    }

    /**
     * @param mixed $native
     * @param array $args [optional]
     * @param bool $bind [optional]
     * @return array
     * @throws \axy\callbacks\errors\InvalidFormat
     */
    private static function getNative($native, $args = null, $bind = false)
    {
        if (!is_array($args)) {
            if ($args !== null) {
                throw new InvalidFormat('Args must be an array');
            }
            $args = [];
        }
        if ($bind) {
            if (!is_array($native)) {
                throw new InvalidFormat('Invalid callback for bind context');
            }
        } elseif (!is_callable($native, true)) {
            throw new InvalidFormat();
        }
        return [
            'native' => $native,
            'args' => $args,
            'bind' => $bind,
        ];
    }

    /**
     * @param mixed $callback
     * @param array $args
     * @param bool $bind
     * @return array
     * @throws \axy\callbacks\errors\InvalidFormat
     */
    private static function getFromDictByObject($callback, $args, $bind)
    {
        if (isset($callback['method'])) {
            $callback = [$callback['object'], $callback['method']];
        } else {
            $callback = $callback['object'];
        }
        return self::getNative($callback, $args, $bind);
    }

    /**
     * @param mixed $callback
     * @param array $args
     * @param bool $bind
     * @return array
     * @throws \axy\callbacks\errors\InvalidFormat
     */
    private static function getFromDictByClass($callback, $args, $bind)
    {
        if (isset($callback['method'])) {
            $callback = [$callback['class'], $callback['method']];
        } else {
            throw new InvalidFormat('Class "'.$callback['class'].'" require static method');
        }
        return self::getNative($callback, $args, $bind);
    }


    private function __construct()
    {
    }

    /**
     * @param string $methodName
     * @param array $args [optional]
     * @return \Closure
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod) this method called from a callback
     */
    private function createClosure($methodName, $args)
    {
        if (empty($args)) {
            $args = null;
        }
        return function () use ($methodName, $args) {
            $a = func_get_args();
            if ($args !== null) {
                $a = array_merge($a, $args);
            }
            return call_user_func_array([$this, $methodName], $a);
        };
    }
}

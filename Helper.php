<?php
/**
 * @package axy\callbacks
 */

namespace axy\callbacks;

use axy\callbacks\errors\InvalidFormat;

/**
 * The helper for work with the callback format
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
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
     * @param mixed $callback
     * @return array
     * @throws \axy\callbacks\errors\InvalidFormat
     */
    private static function getFromList($callback)
    {
        if (!isset($callback[1])) {
            return self::getNative($callback[0], $callback[2]);
        }
        if ($callback[0] === null) {
            return self::getNative($callback[1], $callback[2]);
        }
        return self::getNative([$callback[0], $callback[1]], $callback[2]);
    }

    /**
     * @param mixed $callback
     * @return array
     * @throws \axy\callbacks\errors\InvalidFormat
     */
    private static function getFromDict($callback)
    {
        $args = isset($callback['args']) ? $callback['args'] : [];
        if (isset($callback['function'])) {
            return self::getNative($callback['function'], $args);
        }
        if (isset($callback['object'])) {
            if (isset($callback['method'])) {
                $callback = [$callback['object'], $callback['method']];
            } else {
                $callback = $callback['object'];
            }
            return self::getNative($callback, $args);
        }
        if (isset($callback['class'])) {
            if (isset($callback['method'])) {
                $callback = [$callback['class'], $callback['method']];
            } else {
                throw new InvalidFormat('Class "'.$callback['class'].'" require static method');
            }
            return self::getNative($callback, $args);
        }
        throw new InvalidFormat();
    }

    /**
     * @param mixed $native
     * @param array $args [optional]
     * @return array
     * @throws \axy\callbacks\errors\InvalidFormat
     */
    private static function getNative($native, $args = null)
    {
        if (!is_array($args)) {
            if ($args !== null) {
                throw new InvalidFormat('Args must be an array');
            }
            $args = [];
        }
        if (!is_callable($native, true)) {
            throw new InvalidFormat();
        }
        return [
            'native' => $native,
            'args' => $args,
        ];
    }
}

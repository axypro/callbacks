<?php
/**
 * Extension of php-callback format
 *
 * @package axy\callbacks
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 * @license https://raw.github.com/axypro/callbacks/master/LICENSE MIT
 * @uses PHP5.4+
 */

namespace axy\callbacks;

if (!\is_file(__DIR__.'/vendor/autoload.php')) {
    throw new \LogicException('Please: ./composer.phar install --dev');
}

require_once(__DIR__.'/vendor/autoload.php');

<?php
/**
 * Extension of php-callback format
 *
 * @package axy\callbacks
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 * @license https://raw.github.com/axypro/callbacks/master/LICENSE MIT
 * @link https://github.com/axypro/callbacks repository
 * @link https://github.com/axypro/callbacks/blob/master/doc/README.md documentation
 * @link https://packagist.org/packages/axy/callbacks on packagist.org
 * @uses PHP5.4+
 */

namespace axy\callbacks;

if (!is_file(__DIR__.'/vendor/autoload.php')) {
    throw new \LogicException('Please: composer install');
}

require_once(__DIR__.'/vendor/autoload.php');

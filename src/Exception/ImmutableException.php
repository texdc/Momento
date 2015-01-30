<?php
/**
 * ImmutableException.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento\Exception;

use ErrorException;

/**
 * Announces a mutation violation
 *
 * @see    \Momento\EventResult::__set()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class ImmutableException extends ErrorException
{
}

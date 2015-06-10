<?php
/**
 * ImmutableException.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\exception;

use ErrorException;

/**
 * Announces a mutation violation
 *
 * @see    texdc\momento\EventResult::__set()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class ImmutableException extends ErrorException
{
}

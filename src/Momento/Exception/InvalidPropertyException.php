<?php
/**
 * InvalidPropertyException.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento\Exception;

use ErrorException;

/**
 * Announces an invalid property
 *
 * @see    \Momento\EventResult::__get()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class InvalidPropertyException extends ErrorException
{
}

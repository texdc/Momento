<?php
/**
 * UnknownEventIdException.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\exception;

use InvalidArgumentException;

/**
 * Announces an unknown event id
 *
 * @see    texdc\momento\EventStoreInterface::findById()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class UnknownEventIdException extends InvalidArgumentException
{
}

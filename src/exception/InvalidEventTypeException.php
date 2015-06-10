<?php
/**
 * InvalidEventTypeException.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\exception;

use InvalidArgumentException;

/**
 * Announces an invalid event type
 *
 * @see    texdc\momento\EventPublisher::guardValidEventType()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class InvalidEventTypeException extends InvalidArgumentException
{
}

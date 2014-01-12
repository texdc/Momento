<?php
/**
 * InvalidEventTypeException.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento\Exception;

use InvalidArgumentException;

/**
 * Announces an invalid event type
 *
 * @see    \Momento\EventPublisher::guardValidEventType()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class InvalidEventTypeException extends InvalidArgumentException
{
}

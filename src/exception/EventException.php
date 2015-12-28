<?php
/**
 * EventException.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\exception;

use DomainException;

/**
 * Announces an event exception
 *
 * @see    texdc\momento\EventPublisher::guardValidEventType()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class EventException extends DomainException
{
    /**
     * @param  string $anEventType
     * @return self
     */
    public static function invalidType($anEventType)
    {
        return new static("Invalid event type [$anEventType]");
    }
}

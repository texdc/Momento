<?php
/**
 * EventException.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\exception;

use DomainException;
use Exception;

/**
 * Announces an event exception
 *
 * @see    texdc\momento\EventPublisher::guardValidEventType()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
final class EventException extends DomainException
{
    /**#@+
     * Exception code constants
     * @var int
     */
    const CODE_INVALID_TYPE = 11;
    /**#@- */

    /**
     * Announces an invalid event type
     *
     * @param  string    $anEventType an event type
     * @param  Exception $anException a previous exception
     * @return self
     */
    public static function invalidType($anEventType, Exception $anException = null)
    {
        return new static("Invalid event type [$anEventType]", static::CODE_INVALID_TYPE, $anException);
    }
}

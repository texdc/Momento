<?php
/**
 * EventException.php
 *
 * @copyright 2017 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\exception;

use DomainException;
use Exception;

/**
 * Announces an event exception
 *
 * @author George D. Cooksey, III
 */
final class EventException extends DomainException
{
    /**#@+
     * Exception code constants
     * @var int
     */
    const CODE_INVALID_TYPE = 11;
    const CODE_INVALID_ID   = 12;
    /**#@- */

    /**
     * Announces an invalid event type
     *
     * @param  string    $anEventType an event type
     * @param  Exception $anException a previous exception
     * @return self
     */
    public static function invalidType(string $anEventType, Exception $anException = null) : self
    {
        return new static("Invalid event type [$anEventType]", static::CODE_INVALID_TYPE, $anException);
    }

    /**
     * Announces an invalid id format
     *
     * @param  string    $anEventId   an event id
     * @param  Exception $anException a previous exception
     * @return self
     */
    public static function invalidId(string $anEventId, Exception $anException = null) : self
    {
        return new static("Invalid id format [$anEventId]", static::CODE_INVALID_ID, $anException);
    }
}

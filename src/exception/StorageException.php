<?php
/**
 * StorageException.php
 *
 * @copyright 2017 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\exception;

use DomainException;
use Exception;

/**
 * Announces event storage exceptions
 *
 * @author George D. Cooksey, III
 */
final class StorageException extends DomainException
{
    /**#@+
     * Exception code constants
     * @var int
     */
    const CODE_DUPLICATE_EVENT  = 21;
    const CODE_UNKNOWN_EVENT_ID = 22;
    /**#@- */

    /**
     * @param  string    $anEventId   an event id
     * @param  Exception $anException a previous exception
     * @return self
     */
    public static function duplicateEvent(string $anEventId, Exception $anException = null) : self
    {
        return new static("Duplicate event [$anEventId]", static::CODE_DUPLICATE_EVENT, $anException);
    }

    /**
     * @param  string    $anEventId   an event id
     * @param  Exception $anException a previous exception
     * @return self
     */
    public static function unknownEventId(string $anEventId, Exception $anException = null) : self
    {
        return new static("Unrecognized event id [$anEventId]", static::CODE_UNKNOWN_EVENT_ID, $anException);
    }
}

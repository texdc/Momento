<?php
/**
 * HandlerException.php
 *
 * @copyright 2017 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\exception;

use DomainException;
use Exception;

/**
 * Announces a handler exception
 *
 * @author George D. Cooksey, III
 */
final class HandlerException extends DomainException
{
    /**#@+
     * Exception code constants
     * @var int
     */
    const CODE_DUPLICATE = 31;
    /**#@- */

    /**
     * Announces a duplicate handler
     *
     * @param callable  $aHandler
     * @param Exception $anException
     * @see   texdc\momento\HandlerQueue::insert()
     */
    public static function duplicate(callable $aHandler, Exception $anException = null) : self
    {
        $message = sprintf('Duplicate handler [%s]', get_class($aHandler));
        return new static($message, static::CODE_DUPLICATE, $anException);
    }
}

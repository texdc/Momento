<?php
/**
 * DuplicateHandlerException.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\exception;

use Exception as SplException;
use InvalidArgumentException;
use texdc\momento\EventHandlerInterface;

/**
 * Announces a duplicate handler
 *
 * @see    texdc\momento\HandlerQueue::insert()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class DuplicateHandlerException extends InvalidArgumentException
{
    /**
     * @var string
     */
    const DEFAULT_MESSAGE = 'Duplicate handler';

    /**
     * Constructor
     *
     * @param string|EventHandler $message
     * @param string|null         $code
     * @param SplException|null   $previous
     */
    public function __construct(
        $message = self::DEFAULT_MESSAGE,
        $code = null,
        SplException $previous = null
    ) {
        if (is_callable($message)) {
            $message = sprintf('%s [%s]', static::DEFAULT_MESSAGE, get_class($message));
        }
        parent::__construct($message, $code, $previous);
    }
}

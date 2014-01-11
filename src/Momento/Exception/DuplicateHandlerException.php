<?php
/**
 * DuplicateHandlerException.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento\Exception;

use Exception as SplException;
use InvalidArgumentException;
use Momento\EventHandler;

/**
 * Announces a duplicate handler
 *
 * @see    \Momento\HandlerQueue::insert()
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
        if ($message instanceof EventHandler) {
            $message = sprintf('%s [%s]', static::DEFAULT_MESSAGE, get_class($message));
        }
        parent::__construct($message, $code, $previous);
    }
}
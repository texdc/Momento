<?php
/**
 * HandlingHaltedException.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento\Exception;

use Exception as SplException;
use RuntimeException;

use Momento\Event;
use Momento\EventHandler;

/**
 * Announces that event handling has been halted
 *
 * @see    \Momento\EventPublisher::publish()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class HandlingHaltedException extends RuntimeException
{
    /**
     * @var string
     */
    const DEFAULT_MESSAGE = 'Handling halted';

    /**
     * Constructor
     *
     * @param string|Event        $message
     * @param string|EventHandler $code
     * @param SplException|null   $previous
     */
    public function __construct(
        $message = self::DEFAULT_MESSAGE,
        $code = null,
        SplException $previous = null
    ) {
        if ($message instanceof Event) {
            $message = sprintf(
                '%s for [%s]',
                static::DEFAULT_MESSAGE,
                $message->eventType()
            );
        }
        if ($code instanceof EventHandler) {
            $message .= sprintf(' by [%s]', get_class($code));
            $code = null;
        }
        parent::__construct($message, $code, $previous);
    }
}

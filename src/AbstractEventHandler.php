<?php
/**
 * AbstractEventHandler.php
 *
 * @copyright 2017 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento;

use texdc\momento\exception\EventException;

/**
 * A basic implementation of the {@link EventHandlerInteface}
 *
 * @author George D. Cooksey, III
 */
abstract class AbstractEventHandler implements EventHandlerInterface
{
    /**
     * @var string[]
     */
    protected static $validEventTypes = [];

    /**
     * List the events that are valid for this handler
     *
     * @return string[]
     */
    public function validEventTypes() : array
    {
        return static::$validEventTypes;
    }

    /**
     * Verify a handled event type
     *
     * @param  string $anEventType the event type to verify
     * @return bool
     */
    public static function validateEventType(string $anEventType) : bool
    {
        return in_array($anEventType, static::$validEventTypes);
    }

    /**
     * Protects against invalid event types
     *
     * @param  string $anEventType the event type to verify
     * @throws EventException - on invalid event type
     */
    protected function guardValidEventType(string $anEventType)
    {
        if (!static::validateEventType($anEventType)) {
            throw EventException::invalidType($anEventType);
        }
    }
}

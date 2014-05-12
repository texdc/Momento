<?php
/**
 * EventHandlerTrait.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

use Momento\Exception\InvalidEventTypeException;

/**
 * A basic implementation of the {@link EventHandlerInteface}
 *
 * @author George D. Cooksey, III
 */
trait EventHandlerTrait
{
    /**
     * List the events that are valid for this handler
     *
     * @return string[]
     */
    public function validEventTypes()
    {
        return static::$validEventTypes;
    }

    /**
     * Verify a handled event type
     *
     * @param  string $anEventType the event type to verify
     * @return bool
     */
    public static function validateEventType($anEventType)
    {
        return in_array($anEventType, static::$validEventTypes);
    }

    /**
     * Protects against invalid event types
     *
     * @param  string $anEventType the event type to verify
     * @throws InvalidEventTypeException
     */
    private function guardValidEventType($anEventType)
    {
        if (!static::validateEventType($anEventType)) {
            throw new InvalidEventTypeException(
                "$anEventType is not a valid event type"
            );
        }
    }
}

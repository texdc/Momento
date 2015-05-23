<?php
/**
 * AbstractEventHandler.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

use Momento\Exception\InvalidEventTypeException;

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
    public function validEventTypes()
    {
        return static::$validEventTypes;
    }

    /**
     * (non-PHPdoc)
     * @see \Momento\LimitsEventTypesInterface::acceptsEventType()
     */
    public function acceptsEventType($anEventType)
    {
        return in_array($anEventType, static::$validEventTypes);
    }

    /**
     * Protects against invalid event types
     *
     * @param  string $anEventType the event type to verify
     * @throws InvalidEventTypeException
     */
    protected function guardEventType($anEventType)
    {
        if (!$this->acceptsEventType($anEventType)) {
            throw new InvalidEventTypeException("$anEventType is not a valid event type");
        }
    }
}

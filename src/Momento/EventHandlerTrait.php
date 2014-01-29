<?php
/**
 * EventHandlerTrait.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * A basic implementation of the {@link EventHandler} interface
 *
 * @package Momento
 */
trait EventHandlerTrait
{
    /**
     * @var string[]
     */
    private $handledEventTypes = [];


    /**
     * @see EventHandler::handle()
     */
    abstract public function handle(Event $anEvent);

    /**
     * Is an event type handled?
     *
     * @param  string $anEventType the event type to check
     * @return bool
     */
    public function handles($anEventType)
    {
        return in_array($anEventType, $this->handledEventTypes);
    }

    /**
     * @return string[]
     */
    public function listHandledEventTypes()
    {
        return $this->handledEventTypes;
    }

    /**
     * Validate an event
     *
     * @param  Event $anEvent the event to validate
     * @return void
     * @throws Exception\InvalidEventTypeException
     */
    private function validate(Event $anEvent)
    {
        $eventType = $anEvent->getType();
        if (!$this->handles($eventType)) {
            throw new Exception\InvalidEventTypeException(
                "$eventType is not a valid event type"
            );
        }
    }

    /**
     * Set the handled event types
     *
     * @param  string[] $handledEventTypes the handled event types
     * @return void
     */
    private function setHandledEventTypes(array $handledEventTypes = [])
    {
        $this->handledEventTypes = $handledEventTypes;
    }
}

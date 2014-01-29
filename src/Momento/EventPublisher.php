<?php
/**
 * EventPublisher.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

use Momento\Exception\InvalidEventTypeException;

/**
 * Manages a prioritized set of {@link EventHandler} instances by event type.
 *
 * @package Momento
 */
class EventPublisher
{

    /**
     * @var EventHandler[]
     */
    protected $handlers = [];

    /**
     * @var string[] event type => enabled flag
     */
    protected $validEventTypes = [];


    /**
     * Constructor
     *
     * If $handlers is multi-dimensional, the inner array(s) must have two keys,
     * handler and priority.
     *
     * @param string[] $validEventTypes the event types valid for this publisher
     * @param array    $handlers        the handlers to register
     */
    public function __construct(array $validEventTypes, array $handlers = [])
    {
        $this->setValidEventTypes($validEventTypes);
        foreach ($handlers as $handler) {
            $priority = 0;
            if (is_array($handler)) {
                extract($handler, EXTR_OVERWRITE);
            }
            $this->register($handler, $priority);
        }
    }

    /**
     * Publish an event
     *
     * Published events are verified against a list of enabled types.
     *
     * @param  Event $event the event to publish
     * @return void
     */
    public function publish(Event $event)
    {
        $eventType = $event->getType();
        $this->guardEnabledEventType($eventType);
        foreach ($this->handlers[$eventType] as $handler) {
            $handler->handle($event);
        }
    }

    /**
     * Enable an event type
     *
     * @param  string $eventType the event type to enable
     * @return void
     */
    public function enable($eventType)
    {
        $this->guardValidEventType((string) $eventType);
        $this->validEventTypes[(string) $eventType] = true;
    }

    /**
     * Disable an event type
     *
     * @param  string $eventType the event type to disable
     * @return void
     */
    public function disable($eventType)
    {
        $this->guardValidEventType((string) $eventType);
        $this->validEventTypes[(string) $eventType] = false;
    }

    /**
     * Register a handler
     *
     * Any event types handled by the handler which are not valid for this publisher
     * will be overlooked to prevent unnecessary handler queues.
     *
     * @param  EventHandler $handler      the handler to register
     * @param  int          $withPriority the handler's priority
     * @return void
     */
    public function register(EventHandler $handler, $withPriority = 0)
    {
        foreach ($handler->listHandledEventTypes() as $eventType) {
            try {
                $this->guardValidEventType($eventType);
                if (!isset($this->handlers[$eventType])) {
                    $this->handlers[$eventType] = new HandlerQueue;
                }
                $this->handlers[$eventType]->insert($handler, $withPriority);
            } catch (InvalidEventTypeException $exception) {
                continue;
            }
        }
    }

    /**
     * Unregister a handler
     *
     * @param  EventHandler $handler the handler to unregister
     * @return void
     */
    public function unregister(EventHandler $handler)
    {
        foreach ($handler->listHandledEventTypes() as $eventType) {
            if (isset($this->handlers[$eventType])) {
                $this->handlers[$eventType]->remove($handler);
            }
        }
    }

    /**
     * Get the registered handlers
     *
     * @return EventHandler[]
     */
    public function listRegisteredHandlers($forEventType = null)
    {
        if (isset($forEventType) && isset($this->handlers[$forEventType])) {
            return $this->handlers[$forEventType]->toArray();
        }
        return $this->handlers;
    }

    /**
     * Get the valid event types
     *
     * @return string[]
     */
    public function listValidEventTypes()
    {
        return array_keys($this->validEventTypes);
    }

    /**
     * Get the enabled event types
     *
     * @return string[]
     */
    public function listEnabledEventTypes()
    {
        return array_keys($this->validEventTypes, true);
    }

    /**
     * Get the disabled event types
     *
     * @return string[]
     */
    public function listDisabledEventTypes()
    {
        return array_keys($this->validEventTypes, false);
    }

    /**
     * Set the valid event types
     *
     * Each event type is stored as an array with the event type as the key and a
     * boolean enabled flag as the value.
     *
     * @param  string[] $validEventTypes
     * @return void
     */
    protected function setValidEventTypes(array $validEventTypes)
    {
        foreach ($validEventTypes as $eventType) {
            $this->validEventTypes[(string) $eventType] = true;
        }
    }

    /**
     * Verifies an event type for validity
     *
     * @param  string $eventType the event type to verify
     * @throws InvalidEventTypeException
     * @return void
     */
    protected function guardValidEventType($eventType)
    {
        if (!in_array($eventType, $this->listValidEventTypes())) {
            throw new InvalidEventTypeException("Invalid event type [$eventType]");
        }
    }

    /**
     * Verifies an event type as enabled
     *
     * @param  string $eventType the event type to verify
     * @throws InvalidEventTypeException
     * @return void
     */
    protected function guardEnabledEventType($eventType)
    {
        if (!in_array($eventType, $this->listEnabledEventTypes())) {
            throw new InvalidEventTypeException("Disabled event type [$eventType]");
        }
    }
}

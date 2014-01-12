<?php
/**
 * EventPublisher.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

use Momento\Exception\HandlingHaltedException;

/**
 * Registers {@link EventHandler} and publishes {@link Event}
 *
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class EventPublisher
{

    /**
     * @var EventHandler[]
     */
    protected $handlers = [];


    /**
     * Constructor
     *
     * If $handlers is multi-dimensional, the inner array(s) must have two keys,
     * handler and priority.
     *
     * @param array $handlers the handlers to register
     */
    public function __construct(array $handlers = [])
    {
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
     * @param  Event $event the event to publish
     * @throws HandlingHaltedException - when event handling has been halted
     * @return void
     */
    public function publish(Event $event)
    {
        foreach ($this->handlers[$event->eventType()] as $handler) {
            if (false == $handler->handle($event)) {
                throw new HandlingHaltedException($event, $handler);
            }
        }
    }

    /**
     * Register a handler
     *
     * @param EventHandler $handler the handler to register
     *
     * @return void
     */
    public function register(EventHandler $handler, $priority = 0)
    {
        foreach ($handler->listHandledEventTypes() as $eventType) {
            if (!isset($this->handlers[$eventType])) {
                $this->handlers[$eventType] = new HandlerQueue;
            }
            $this->handlers[$eventType]->insert($handler, $priority);
        }
    }

    /**
     * Unregister a handler
     *
     * @param EventHandler $handler the handler to unregister
     *
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
}

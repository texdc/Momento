<?php
/**
 * EventPublisher.php
 *
 * @copyright 2013 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

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
            if (is_array($handler)) {
                $this->register($handler['handler'], $handler['priority']);
            } else {
                $this->register($handler);
            }
        }
    }

    /**
     * Publish an event
     *
     * @param Event $event the event to publish
     *
     * @return void
     */
    public function publish(Event $event)
    {
        foreach ($this->handlers[$event->eventType()] as $handler) {
            $handler->handle($event);
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
                $this->handlers[$eventType] = new SubscriberQueue;
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
     * Get the handlers
     *
     * @return EventHandler[]
     */
    public function handlers($forEventType = null)
    {
        if (isset($forEventType) && isset($this->handlers[$forEventType])) {
            return $this->handlers[$forEventType]->toArray();
        }
        return $this->handlers;
    }
}

<?php
/**
 * DomainEventPublisher.php
 *
 * @copyright 2013 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Registers {@link DomainEventSubscriber} and publishes {@link Event}
 *
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class DomainEventPublisher
{

    /**
     * @var DomainEventSubscriber[]
     */
    protected $subscribers = [];


    /**
     * Constructor
     *
     * If $subscribers is multi-dimensional, the inner array(s) must have two keys,
     * subscriber and priority.
     *
     * @param array $subscribers the subscribers to register
     */
    public function __construct(array $subscribers = [])
    {
        foreach ($subscribers as $subscriber) {
            if (is_array($subscriber)) {
                $this->register($subscriber['subscriber'], $subscriber['priority']);
            } else {
                $this->register($subscriber);
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
        foreach ($this->subscribers[$event->eventType()] as $subscriber) {
            $subscriber->handle($event);
        }
    }

    /**
     * Register a subscriber
     *
     * @param DomainEventSubscriber $subscriber the subscriber to register
     *
     * @return void
     */
    public function register(DomainEventSubscriber $subscriber, $priority = 0)
    {
        foreach ($subscriber->listHandledEventTypes() as $eventType) {
            if (!isset($this->subscribers[$eventType])) {
                $this->subscribers[$eventType] = new SubscriberQueue;
            }
            $this->subscribers[$eventType]->insert($subscriber, $priority);
        }
    }

    /**
     * Unregister a subscriber
     *
     * @param DomainEventSubscriber $subscriber the subscriber to unregister
     *
     * @return void
     */
    public function unregister(DomainEventSubscriber $subscriber)
    {
        foreach ($subscriber->listHandledEventTypes() as $eventType) {
            if (isset($this->subscribers[$eventType])) {
                $this->subscribers[$eventType]->remove($subscriber);
            }
        }
    }

    /**
     * Get the subscribers
     *
     * @return DomainEventSubscriber[]
     */
    public function subscribers($forEventType = null)
    {
        if (isset($forEventType) && isset($this->subscribers[$forEventType])) {
            return $this->subscribers[$forEventType]->toArray();
        }
        return $this->subscribers;
    }
}

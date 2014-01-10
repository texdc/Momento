<?php
/**
 * DomainEventPublisher.php
 *
 * @copyright 2013 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Registers {@link DomainEventSubscriber}s and publishes {@link DomainEvent}s
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
     * @param DomainEventSubscriber[] $subscribers the subscribers to register
     */
    public function __construct(array $subscribers = [])
    {
        foreach ($subscribers as $subscriber) {
            $this->register($subscriber);
        }
    }

    /**
     * Publish an event
     *
     * @param DomainEvent $event the event to publish
     *
     * @return void
     */
    public function publish(DomainEvent $event)
    {
        $eventType = $event->eventType();
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->handlesEventType($eventType)) {
                $subscriber->handle($event);
            }
        }
    }

    /**
     * Register a subscriber
     *
     * @param DomainEventSubscriber $subscriber the subscriber to register
     *
     * @return void
     */
    public function register(DomainEventSubscriber $subscriber)
    {
        $this->subscribers[spl_object_hash($subscriber)] = $subscriber;
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
        unset($this->subscribers[spl_object_hash($subscriber)]);
    }

    /**
     * Get the subscribers
     *
     * @return DomainEventSubscriber[]
     */
    public function subscribers()
    {
        return $this->subscribers;
    }
}

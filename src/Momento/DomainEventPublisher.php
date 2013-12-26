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
        $eventType = get_class($event);
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->subscribedEventType() == $eventType) {
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
        if (!in_array($subscriber, $this->subscribers)) {
            $this->subscribers[] = $subscriber;
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
        if (!in_array($subscriber, $this->subscribers)) {
            return;
        }
        foreach ($this->subscribers as $index => $registered) {
            if ($registered == $subscriber) {
                unset($this->subscribers[$index]);
                break;
            }
        }
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

    /**
     * Compare another domain event publisher for equality
     *
     * @param self $other the other publisher
     *
     * @return bool
     */
    public function equals(self $other)
    {
        return ($this->subscribers == $other->subscribers);
    }
}

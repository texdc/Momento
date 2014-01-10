<?php
/**
 * SubscriberQueue.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use SplPriorityQueue;

/**
 * A reusable, prioritized queue for {@link DomainEventSubscriber} instances
 *
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class SubscriberQueue implements Countable, IteratorAggregate
{
    /**
     * The queued subscribers
     * @var array
     */
    private $subscribers = [];

    /**
     * The internal queue
     * @var SplPriorityQueue
     */
    private $queue;

    /**
     * The internal queue ordering regulator
     * @var int
     */
    private $queueOrder = PHP_INT_MAX;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Prevents duplicates and enforces an expected FIFO queue order
     *
     * @param  DomainEventSubscriber $subscriber the subscriber to insert
     * @param  int                   $priority   the subscriber's priority
     * @throws InvalidArgumentException - on duplicate subscriber
     */
    public function insert(DomainEventSubscriber $subscriber, $priority)
    {
        if ($this->contains($subscriber)) {
            throw new InvalidArgumentException('Duplicate subscriber');
        }
        $priority = [(int) $priority, $this->queueOrder--];
        $this->subscribers[] = compact('subscriber', 'priority');
        $this->queue->insert($subscriber, $priority);
    }

    /**
     * Remove a subscriber and reset the queue
     *
     * @param DomainEventSubscriber $subscriber the subscriber to remove
     */
    public function remove(DomainEventSubscriber $subscriber)
    {
        foreach ($this->subscribers as $key => $item) {
            if ($item['subscriber'] == $subscriber) {
                unset($this->subscribers[$key]);
                $this->reset();
                break;
            }
        }
    }

    /**
     * Is a subscriber contained?
     *
     * @param  DomainEventSubscriber $subscriber the subscriber to check
     * @return bool
     */
    public function contains(DomainEventSubscriber $subscriber)
    {
        return (in_array($subscriber, $this->toArray(), true));
    }

    /**
     * Get the queue as an array
     *
     * @return array
     */
    public function toArray()
    {
        $subscribers = [];
        foreach ($this->getIterator() as $item) {
            $subscribers[] = $item;
        }
        return $subscribers;
    }

    /**
     * Count the subscribers
     *
     * @return int
     */
    public function count()
    {
        return count($this->subscribers);
    }

    /**
     * Get the internal queue
     *
     * @return SplPriorityQueue
     */
    public function getIterator()
    {
        return clone $this->queue;
    }

    /**
     * Get the first subscriber in the queue
     *
     * @return DomainEventSubscriber
     */
    public function top()
    {
        return $this->getIterator()->top();
    }

    /**
     * Reset the queue
     */
    public function reset()
    {
        $this->queue = new SplPriorityQueue;
        foreach ($this->subscribers as $item) {
            $this->queue->insert($item['subscriber'], $item['priority']);
        }
    }
}

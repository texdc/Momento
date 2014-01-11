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
 * A reusable, prioritized queue for {@link EventHandler} instances
 *
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class SubscriberQueue implements Countable, IteratorAggregate
{
    /**
     * The queued handlers
     * @var array
     */
    private $handlers = [];

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
     * @param  EventHandler $handler the handler to insert
     * @param  int                   $priority   the handler's priority
     * @throws InvalidArgumentException - on duplicate handler
     */
    public function insert(EventHandler $handler, $priority)
    {
        if ($this->contains($handler)) {
            throw new InvalidArgumentException('Duplicate handler');
        }
        $priority = [(int) $priority, $this->queueOrder--];
        $this->handlers[] = compact('handler', 'priority');
        $this->queue->insert($handler, $priority);
    }

    /**
     * Remove a handler and reset the queue
     *
     * @param EventHandler $handler the handler to remove
     */
    public function remove(EventHandler $handler)
    {
        foreach ($this->handlers as $key => $item) {
            if ($item['handler'] == $handler) {
                unset($this->handlers[$key]);
                $this->reset();
                break;
            }
        }
    }

    /**
     * Is a handler contained?
     *
     * @param  EventHandler $handler the handler to check
     * @return bool
     */
    public function contains(EventHandler $handler)
    {
        return (in_array($handler, $this->toArray(), true));
    }

    /**
     * Get the queue as an array
     *
     * @return array
     */
    public function toArray()
    {
        $handlers = [];
        foreach ($this->getIterator() as $item) {
            $handlers[] = $item;
        }
        return $handlers;
    }

    /**
     * Count the handlers
     *
     * @return int
     */
    public function count()
    {
        return count($this->handlers);
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
     * Get the first handler in the queue
     *
     * @return EventHandler
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
        foreach ($this->handlers as $item) {
            $this->queue->insert($item['handler'], $item['priority']);
        }
    }
}

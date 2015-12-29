<?php
/**
 * HandlerQueue.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento;

use Countable;
use IteratorAggregate;
use SplPriorityQueue;

use texdc\momento\exception\HandlerException;

/**
 * A reusable, prioritized queue for {@link EventHandlerInterface} instances
 *
 * @author George D. Cooksey, III
 */
class HandlerQueue implements Countable, IteratorAggregate
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
     * Prevents duplicates and enforces an expected FIFO queue order
     *
     * @param  callable $handler  the handler to insert
     * @param  int      $priority the handler's priority
     * @throws DuplicateHandlerException on duplicate handler
     */
    public function insert(callable $handler, $priority = 0)
    {
        if ($this->contains($handler)) {
            throw HandlerException::duplicate($handler);
        }
        $priority = [(int) $priority, $this->queueOrder--];
        $this->handlers[] = compact('handler', 'priority');
    }

    /**
     * Remove a handler and reset the queue
     *
     * @param callable $handler the handler to remove
     */
    public function remove(callable $handler)
    {
        foreach ($this->handlers as $key => $item) {
            if ($item['handler'] == $handler) {
                unset($this->handlers[$key]);
                break;
            }
        }
    }

    /**
     * Is a handler contained?
     *
     * @param  callable $handler the handler to check
     * @return bool
     */
    public function contains(callable $handler)
    {
        return (in_array($handler, $this->toArray(), true));
    }

    /**
     * Is the handler list empty
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->handlers);
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
        $this->reset();
        return $this->queue;
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

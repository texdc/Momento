<?php
/**
 * SubscriberQueue.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

use InvalidArgumentException;
use SplPriorityQueue;

/**
 * A prioritized queue for {@link DomainEventSubscriber} instances
 *
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class SubscriberQueue extends SplPriorityQueue
{
    /**
     * Get the queue as an array
     *
     * @return array
     */
    public function toArray()
    {
        $contents = [];
        foreach ($this as $contained) {
            $contents[] = $contained;
        }
        return $contents;
    }

    /**
     * Allows only {@link DomainEventSubscriber} instances to be inserted
     *
     * @see SplPriorityQueue::insert()
     */
    public function insert($value, $priority)
    {
        $this->guardValueIsSubscriber($value);
        parent::insert($value, $priority);
    }

    /**
     * Ensures the $value is a {@link DomainEventSubscriber}
     *
     * @param  mixed $value
     * @throws InvalidArgumentException
     */
    private function guardValueIsSubscriber($value)
    {
        if (!is_a($value, 'Momento\DomainEventSubscriber')) {
            $message = sprintf(
                'Inserted elements must be an instance of %s, [%s] provided',
                'Momento\DomainEventSubscriber',
                is_object($value) ? get_class($value) : gettype($value)
            );
            throw new InvalidArgumentException($message);
        }
    }
}

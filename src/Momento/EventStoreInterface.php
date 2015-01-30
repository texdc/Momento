<?php
/**
 * EventStoreInterface.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

use Countable;

use Momento\Exception\AppendingPreventedException;
use Momento\Exception\RemovalPreventedException;

/**
 * Stores {@link EventInterface} instances
 *
 * @author George D. Cooksey, III
 */
interface EventStoreInterface extends Countable
{
    /**
     * Find all the {@link EventInterface}s which occurred between two given timestamps
     *
     * @param  int|float $lowerTime the lower bound timestamp
     * @param  int|float $upperTime the upper bound timestamp
     * @return EventInterface[]
     */
    public function allBetween($lowerTime, $upperTime);

    /**
     * Find all the {@link EventInterface}s which occurred after a given timestamp
     *
     * @param  int|float $timestamp the pivot timestamp
     * @return EventInterface[]
     */
    public function allSince($timestamp);

    /**
     * Append an event
     *
     * @param  EventInterface $event the event to append
     * @throws AppendingPreventedException - when the event cannot be appended
     */
    public function append(EventInterface $event);

    /**
     * Remove a stored event
     *
     * @param  EventId $eventId the event id to remove
     * @throws RemovalPreventedException - when the event cannot be removed
     */
    public function remove(EventId $eventId);
}

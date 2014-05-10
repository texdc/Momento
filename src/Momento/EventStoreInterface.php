<?php
/**
 * EventStoreInterface.php
 *
 * @copyright 2014 George D. Cooksey, III
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
     * Find all the {@link EventInterface}s between two given ids
     *
     * @param  EventId $lowerId the lower bound id
     * @param  EventId $upperId the upper bound id
     * @return EventInterface[]
     */
    public function allBetween(EventId $lowerId, EventId $upperId);

    /**
     * Find all the {@link EventInterface}s after a given id
     *
     * @param  EventId $eventId the pivot id
     * @return EventInterface[]
     */
    public function allSince(EventId $eventId);

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

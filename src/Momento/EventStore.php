<?php
/**
 * EventStore.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

use Countable;

use Momento\Exception\AppendingPreventedException;
use Momento\Exception\RemovalPreventedException;

/**
 * Stores events as {@link StoredEvent} instances
 *
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
interface EventStore extends Countable
{
    /**
     * Find all the {@link StoredEvent}s between two given ids
     *
     * @param int $lowStoredEventId  the lower bound id
     * @param int $highStoredEventId the higher bound id
     *
     * @return StoredEvent[]
     */
    public function allStoredEventsBetween($lowStoredEventId, $highStoredEventId);

    /**
     * Find all the {@link StoredEvent}s after a given id
     *
     * @param int $storedEventId the pivot id
     *
     * @return StoredEvent[]
     */
    public function allStoredEventsSince($storedEventId);

    /**
     * Append an event
     *
     * @param  Event $event the event to append
     * @throws AppendingPreventedException - when the event cannot be appended
     * @return StoredEvent
     */
    public function append(Event $event);

    /**
     * Remove a stored event
     *
     * @param  StoredEvent $storedEvent the stored event to remove
     * @throws RemovalPreventedException - when the event cannot be removed
     * @return void
     */
    public function remove(StoredEvent $storedEvent);
}

<?php
/**
 * EventStore.php
 *
 * @copyright 2013 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

use Countable;

/**
 * Stores {@link Event}s as {@link StoredEvent}s
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
     * Append a {@link Event}
     *
     * @param Event $event the event to append
     *
     * @return StoredEvent
     */
    public function append(Event $event);

    /**
     * Remove a stored event by id
     *
     * @param int $storedEventId the stored event id to remove
     *
     * @return StoredEvent the removed event
     */
    public function remove($storedEventId);
}

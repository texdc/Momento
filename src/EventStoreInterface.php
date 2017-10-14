<?php
/**
 * EventStoreInterface.php
 *
 * @copyright 2017 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento;

use Countable;

/**
 * Stores {@link EventInterface} instances
 *
 * @author George D. Cooksey, III
 */
interface EventStoreInterface extends Countable
{
    /**
     * Find all the events which occurred between two given ids
     *
     * @param  EventId $aLowEventId
     * @param  EventId $aHighEventId
     * @return EventInterface[]
     */
    public function findAllBetween(EventId $aLowEventId, EventId $aHighEventId) : array;

    /**
     * Find all the events which occurred after a given id
     *
     * @param  EventId $anEventId
     * @return EventInterface[]
     */
    public function findAllSince(EventId $anEventId) : array;

    /**
     * Find an event by a given id
     *
     * @param  EventId $anEventId
     * @return EventInterface
     * @throws texdc\momento\exception\StorageException
     */
    public function findById(EventId $anEventId) : EventInterface;

    /**
     * Record an event
     *
     * @param  EventInterface $anEvent
     * @throws texdc\momento\exception\StorageException
     */
    public function record(EventInterface $anEvent);
}

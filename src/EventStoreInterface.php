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
     * Find all the events which occurred between two given ids
     *
     * @param  EventId $aLowEventId
     * @param  EventId $aHighEventId
     * @return EventInterface[]
     */
    public function allBetween(EventId $aLowEventId, EventId $aHighEventId);

    /**
     * Find all the events which occurred after a given id
     *
     * @param  EventId $anEventId
     * @return EventInterface[]
     */
    public function allSince(EventId $anEventId);

    /**
     * Append an event
     *
     * @param  EventInterface $anEvent
     * @throws AppendingPreventedException - when the event cannot be appended
     */
    public function append(EventInterface $anEvent);
}

<?php
/**
 * MemoryStore.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento\EventStore;

use Momento\EventId;
use Momento\EventInterface;
use Momento\Exception\AppendingPreventedException;

/**
 * Stores {@link EventInterface} instances in memory
 *
 * @author George D. Cooksey, III
 */
class MemoryStore extends AbstractTypeRestrictedStore
{
    /**
     * @var EventInterface[]
     */
    private $events = [];

    /**
     * (non-PHPdoc)
     * @see    \Momento\EventStoreInterface::allBetween()
     * @throws \Momento\Exception\InvalidEventTypeException
     */
    public function allBetween(EventId $aLowEventId, EventId $aHighEventId)
    {
        $this->guardEventType($aLowEventId->eventType());
        $this->guardEventType($aHighEventId->eventType());
        return array_filter($this->events, function(EventInterface $anEvent) use ($aLowEventId, $aHighEventId) {
            $id = $anEvent->eventId();
            return ($aLowEventId->occurredBefore($id) && $aHighEventId->occurredAfter($id));
        });
    }

    /**
     * (non-PHPdoc)
     * @see    \Momento\EventStoreInterface::allSince()
     * @throws \Momento\Exception\InvalidEventTypeException
     */
    public function allSince(EventId $anEventId)
    {
        $this->guardEventType($anEventId->eventType());
        return array_filter($this->events, function(EventInterface $anEvent) use ($anEventId) {
            return $anEventId->occurredBefore($anEvent->eventId());
        });
    }

    /**
     * (non-PHPdoc)
     * @see    \Momento\EventStoreInterface::append()
     * @throws \Momento\Exception\InvalidEventTypeException
     * @throws \Momento\Exception\AppendingPreventedException
     */
    public function append(EventInterface $anEvent)
    {
        $this->guardEventType($anEvent->eventType());
        $eventId = (string) $anEvent->eventId();
        if (isset($this->events[$eventId])) {
            throw new AppendingPreventedException("Duplicate event [$eventId]");
        }
        $this->events[$eventId] = $anEvent;
    }

    /**
     * (non-PHPdoc)
     * @see Countable::count()
     */
    public function count()
    {
        return count($this->events);
    }
}

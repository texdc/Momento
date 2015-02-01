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
use Momento\EventStoreInterface;
use Momento\Exception\AppendingPreventedException;

/**
 * Stores {@link EventInterface} instances in memory
 *
 * @author George D. Cooksey, III
 */
class MemoryStore implements EventStoreInterface
{
    /**
     * @var EventInterface[]
     */
    private $events = [];

    /**
     * (non-PHPdoc)
     * @see \Momento\EventStoreInterface::allBetween()
     */
    public function allBetween(EventId $aLowEventId, EventId $aHighEventId)
    {
        return array_filter($this->events, function(EventInterface $anEvent) use ($aLowEventId, $aHighEventId) {
            $id = $anEvent->eventId();
            return ($aLowEventId->occurredBefore($id) && $aHighEventId->occurredAfter($id));
        });
    }

    /**
     * (non-PHPdoc)
     * @see \Momento\EventStoreInterface::allSince()
     */
    public function allSince(EventId $anEventId)
    {
        return array_filter($this->events, function(EventInterface $anEvent) use ($anEventId) {
            return $anEventId->occurredBefore($anEvent->eventId());
        });
    }

    /**
     * (non-PHPdoc)
     * @see \Momento\EventStoreInterface::append()
     */
    public function append(EventInterface $anEvent)
    {
        $eventId = (string) $anEvent->eventId();
        if (isset($this->events[$eventId])) {
            throw new AppendingPreventedException("Event cannot be appended [$eventId]");
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

<?php
/**
 * MemoryStore.php
 *
 * @copyright 2017 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\storage;

use texdc\momento\EventId;
use texdc\momento\EventInterface;
use texdc\momento\exception\StorageException;

/**
 * Stores {@link EventInterface} instances in memory
 *
 * Can be used as an in-memory cache for other event store implementations
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
     * @see    texdc\momento\EventStoreInterface::findAllBetween()
     * @throws texdc\momento\exception\InvalidEventTypeException
     */
    public function findAllBetween(EventId $aLowEventId, EventId $aHighEventId) : array
    {
        $this->guardEventType($aLowEventId->eventType());
        $this->guardEventType($aHighEventId->eventType());
        return array_filter($this->events, function (EventInterface $anEvent) use ($aLowEventId, $aHighEventId) {
            $id = $anEvent->eventId();
            return ($aLowEventId->occurredBefore($id) && $aHighEventId->occurredAfter($id));
        });
    }

    /**
     * (non-PHPdoc)
     * @see    texdc\momento\EventStoreInterface::findAllSince()
     * @throws texdc\momento\exception\InvalidEventTypeException
     */
    public function findAllSince(EventId $anEventId) : array
    {
        $this->guardEventType($anEventId->eventType());
        return array_filter($this->events, function (EventInterface $anEvent) use ($anEventId) {
            return $anEventId->occurredBefore($anEvent->eventId());
        });
    }

    /**
     * (non-PHPdoc)
     * @see    texdc\momento\EventStoreInterface::findById()
     * @throws texdc\momento\exception\InvalidEventTypeException
     * @throws texdc\momento\exception\UnknownEventIdException
     */
    public function findById(EventId $anEventId) : EventInterface
    {
        $this->guardEventType($anEventId->eventType());
        if (isset($this->events[(string) $anEventId])) {
            return $this->events[(string) $anEventId];
        }
        throw StorageException::unknownEventId($anEventId);
    }

    /**
     * (non-PHPdoc)
     * @see    texdc\momento\EventStoreInterface::append()
     * @throws texdc\momento\exception\InvalidEventTypeException
     * @throws texdc\momento\exception\AppendingPreventedException
     */
    public function record(EventInterface $anEvent) : void
    {
        $this->guardEventType($anEvent->eventType());
        $eventId = (string) $anEvent->eventId();
        if (isset($this->events[$eventId])) {
            throw StorageException::duplicateEvent($eventId);
        }
        $this->events[$eventId] = $anEvent;
    }

    /**
     * (non-PHPdoc)
     * @see Countable::count()
     */
    public function count() : int
    {
        return count($this->events);
    }
}

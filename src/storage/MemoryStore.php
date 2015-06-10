<?php
/**
 * MemoryStore.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\storage;

use texdc\momento\EventId;
use texdc\momento\EventInterface;
use texdc\momento\exception\AppendingPreventedException;
use texdc\momento\exception\UnknownEventIdException;

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
     * @see    texdc\momento\storageInterface::findAllBetween()
     * @throws texdc\momento\exception\InvalidEventTypeException
     */
    public function findAllBetween(EventId $aLowEventId, EventId $aHighEventId)
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
     * @see    texdc\momento\storageInterface::findAllSince()
     * @throws texdc\momento\exception\InvalidEventTypeException
     */
    public function findAllSince(EventId $anEventId)
    {
        $this->guardEventType($anEventId->eventType());
        return array_filter($this->events, function(EventInterface $anEvent) use ($anEventId) {
            return $anEventId->occurredBefore($anEvent->eventId());
        });
    }

    /**
     * (non-PHPdoc)
     * @see    texdc\momento\storageInterface::findById()
     * @throws texdc\momento\exception\InvalidEventTypeException
     * @throws texdc\momento\exception\UnknownEventIdException
     */
    public function findById(EventId $anEventId)
    {
        $this->guardEventType($anEventId->eventType());
        if (isset($this->events[(string) $anEventId])) {
            return $this->events[(string) $anEventId];
        }
        throw new UnknownEventIdException("Unrecognized event id [$anEventId]");
    }

    /**
     * (non-PHPdoc)
     * @see    texdc\momento\storageInterface::append()
     * @throws texdc\momento\exception\InvalidEventTypeException
     * @throws texdc\momento\exception\AppendingPreventedException
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
<?php
/**
 * AbstractEvent.php
 *
 * @copyright 2017 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento;

use DateTimeInterface;

use texdc\momento\exception\EventException;
use Verraes\ClassFunctions\ClassFunctions;

/**
 * A base implementation of the {@link EventInterface}
 *
 * @author George D. Cooksey, III
 */
abstract class AbstractEvent implements EventInterface
{
    /**
     * @var EventId
     */
    protected $eventId;

    /**
     * Constructor
     *
     * @param EventId|null $eventId
     */
    public function __construct(EventId $eventId = null)
    {
        $this->setEventId($eventId ?: new EventId(ClassFunctions::underscore($this)));
    }

    /**
     * (non-PHPdoc)
     * @see texdc\momento\EventInterface::eventId()
     */
    public function eventId() : EventId
    {
        return $this->eventId;
    }

    /**
     * (non-PHPdoc)
     * @see texdc\momento\EventInterface::occurrenceDate()
     */
    public function occurrenceDate() : DateTimeInterface
    {
        return $this->eventId->occurrenceDate();
    }

    /**
     * (non-PHPdoc)
     * @see texdc\momento\EventInterface::eventType()
     */
    public function eventType() : string
    {
        return $this->eventId->eventType();
    }

    /**
     * Set the event id
     *
     * @param  EventId $eventId the event id
     * @throws EventException - on event type mismatch
     */
    private function setEventId(EventId $eventId) : void
    {
        $eventType = $eventId->eventType();
        if ($eventType != ClassFunctions::underscore($this)) {
            throw EventException::invalidType($eventType);
        }
        $this->eventId = $eventId;
    }
}

<?php
/**
 * AbstractEvent.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento;

use function Verraes\ClassFunctions\underscore;

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
        $this->setEventId($eventId ?: new EventId(underscore($this)));
    }

    /**
     * (non-PHPdoc)
     * @see texdc\momento\EventInterface::eventId()
     */
    public function eventId()
    {
        return $this->eventId;
    }

    /**
     * (non-PHPdoc)
     * @see texdc\momento\EventInterface::occurrenceDate()
     */
    public function occurrenceDate()
    {
        return $this->eventId->occurrenceDate();
    }

    /**
     * (non-PHPdoc)
     * @see texdc\momento\EventInterface::eventType()
     */
    public function eventType()
    {
        return $this->eventId->eventType();
    }

    /**
     * Compare another event for equality
     *
     * @param  AbstractEvent $other the other event to compare
     * @return bool
     */
    public function equals(self $other)
    {
        return $this->eventId == $other->eventId;
    }

    /**
     * Set the event id
     *
     * @param  EventId $eventId the event id
     * @throws \InvalidArgumentException - on event type mismatch
     */
    private function setEventId(EventId $eventId)
    {
        $eventType = $eventId->eventType();
        if ($eventType != underscore($this)) {
            throw new \InvalidArgumentException("Invalid event type [$eventType]");
        }
        $this->eventId = $eventId;
    }
}

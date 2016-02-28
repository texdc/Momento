<?php
/**
 * AbstractEvent.php
 *
 * @copyright 2016 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento;

use texdc\momento\exception\EventException;
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
     * Set the event id
     *
     * @param  EventId $eventId the event id
     * @throws EventException - on event type mismatch
     */
    private function setEventId(EventId $eventId)
    {
        $eventType = $eventId->eventType();
        if ($eventType != underscore($this)) {
            throw EventException::invalidType($eventType);
        }
        $this->eventId = $eventId;
    }
}

<?php
/**
 * StoredEvent.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Decorates a {@link EventInterface} with a unique identifier
 *
 * @author George D. Cooksey, III
 */
class StoredEvent
{

    /**
     * @var int
     */
    protected $eventId;

    /**
     * @var EventInterface
     */
    private $event;


    /**
     * Constructor
     *
     * @param Event $event the event to store
     */
    public function __construct(EventInterface $event)
    {
        $this->event = $event;
    }

    /**
     * Get the event id
     *
     * @return int
     */
    public function eventId()
    {
        return (int) $this->eventId;
    }

    /**
     * Get the event occurred on date
     *
     * @return \DateTime
     */
    public function getOcurrenceDate()
    {
        return $this->event->occurrenceDate();
    }

    /**
     * Get the domain event
     *
     * @return EventInterface
     */
    public function toEvent()
    {
        return $this->event;
    }

    /**
     * Get the event type name
     *
     * @return string
     */
    public function getType()
    {
        return $this->event->eventType();
    }

    /**
     * Compare another StoredEvent for equality
     *
     * @param self $other the event to compare
     *
     * @return bool
     */
    public function equals(self $other)
    {
        return ($this->eventId == $other->eventId);
    }

    /**
     * Convert to a string
     *
     * @return string
     */
    public function __toString()
    {
        $format = 'StoredEvent [eventId=%u, event=%s]';
        return sprintf($format, $this->eventId, get_class($this->event));
    }
}

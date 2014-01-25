<?php
/**
 * StoredEvent.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Decorates a {@link Event} with a unique identifier
 *
 * @package Momento
 */
class StoredEvent
{

    /**
     * @var int
     */
    protected $eventId;

    /**
     * @var Event
     */
    private $event;


    /**
     * Constructor
     *
     * @param Event $event the event to store
     */
    public function __construct(Event $event)
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
        return $this->event->getOcurrenceDate();
    }

    /**
     * Get the domain event
     *
     * @return Event
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
        return $this->event->getType();
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
        return sprintf($format, $this->eventId, $this->event);
    }
}

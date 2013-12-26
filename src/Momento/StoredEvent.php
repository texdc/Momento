<?php
/**
 * StoredEvent.php
 *
 * @copyright 2013 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Decorates a {@link DomainEvent} with a unique identifier
 *
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class StoredEvent
{

    /**
     * @var int
     */
    protected $eventId;

    /**
     * @var DomainEvent
     */
    private $event;


    /**
     * Constructor
     *
     * @param DomainEvent $event the event to store
     */
    public function __construct(DomainEvent $event)
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
    public function occurredOn()
    {
        return $this->event->occurredOn();
    }

    /**
     * Get the domain event
     *
     * @return DomainEvent
     */
    public function toDomainEvent()
    {
        return $this->event;
    }

    /**
     * Get the event type name
     *
     * @return string
     */
    public function typeName()
    {
        return get_class($this->event);
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

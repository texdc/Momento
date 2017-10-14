<?php
/**
 * EventInterface.php
 *
 * @copyright 2016 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento;

use DateTimeInterface;
use JsonSerializable;
use Serializable;

/**
 * Captures the memory of something interesting which affects the domain
 *
 * @link   http://martinfowler.com/eaaDev/DomainEvent.html
 * @author George D. Cooksey, III
 */
interface EventInterface extends JsonSerializable, Serializable
{
    /**
     * Get the unique identifier
     *
     * @return EventId
     */
    public function eventId() : EventId;

    /**
     * Get the event's occurance date
     *
     * @return DateTimeInterface
     */
    public function occurrenceDate() : DateTimeInterface;

    /**
     * Get the event's type
     *
     * @return string
     */
    public function eventType() : string;
}

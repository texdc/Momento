<?php
/**
 * EventInterface.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

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
    public function eventId();

    /**
     * Get the event's occurance date
     *
     * @return \DateTime
     */
    public function occurrenceDate();

    /**
     * Get the event's type
     *
     * @return string
     */
    public function eventType();
}

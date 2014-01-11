<?php
/**
 * Event.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

use DateTime;

/**
 * Captures the memory of something interesting which affects the domain
 *
 * @link   http://martinfowler.com/eaaDev/DomainEvent.html
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
interface Event
{
    /**
     * Get the event's occurance date
     *
     * @return DateTime|int
     */
    public function occurredOn();

    /**
     * Get the event's type
     *
     * @return string
     */
    public function eventType();

    /**
     * Convert to a string
     *
     * @return string
     */
    public function __toString();
}

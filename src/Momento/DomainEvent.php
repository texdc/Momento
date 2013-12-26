<?php
/**
 * DomainEvent.php
 *
 * @copyright 2013 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Captures the memory of something interesting which affects the domain
 *
 * @link   http://martinfowler.com/eaaDev/DomainEvent.html
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
interface DomainEvent
{
    /**
     * Get the event's occurance date
     *
     * @return \DateTime
     */
    public function occurredOn();

    /**
     * Convert to a string
     *
     * @return string
     */
    public function __toString();
}

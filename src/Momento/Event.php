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
 * @link    http://martinfowler.com/eaaDev/DomainEvent.html
 * @package Momento
 */
interface Event
{
    /**
     * Get the event's occurance date
     *
     * @return DateTime|int
     */
    public function getOcurrenceDate();

    /**
     * Get the event's type
     *
     * @return string
     */
    public function getType();

    /**
     * Convert to a string
     *
     * @return string
     */
    public function __toString();
}

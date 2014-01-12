<?php
/**
 * EventResult.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * EventResults may contain a variety of data.  They should keep a reference to the
 * {@link Event} that generated it and a $final flag to denote the halting of furher
 * processing.
 *
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
interface EventResult
{
    /**
     * Get the event
     *
     * @return Event
     */
    public function event();

    /**
     * Should event processing be halted?
     *
     * @return bool
     */
    public function isFinal();
}

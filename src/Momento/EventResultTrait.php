<?php
/**
 * EventResultTrait.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Basic implementation of the {@link EventResult} interface
 *
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
trait EventResultTrait
{
    /**
     * @var Event
     */
    private $event;

    /**
     * @var bool
     */
    private $final = false;

    /**
     * Get the event
     *
     * @return Event
     */
    public function event()
    {
        return $this->event;
    }

    /**
     * Should event proccessing be halted?
     *
     * @return bool
     */
    public function isFinal()
    {
        return $this->final;
    }
}

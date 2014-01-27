<?php
/**
 * EventHandler.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Handles events with either simple processing or delegating complex tasks to a
 * proper service or model.
 *
 * @package Momento
 */
interface EventHandler
{
    /**
     * Process or delegate an {@link Event}
     *
     * @param  Event            $anEvent      the event to handle
     * @param  EventResult|null $aPriorResult optional result from a prior handler
     * @return EventResult
     */
    public function handle(Event $anEvent, EventResult $aPriorResult = null);

    /**
     * List the handled event types
     *
     * @return string[]
     */
    public function listHandledEventTypes();
}
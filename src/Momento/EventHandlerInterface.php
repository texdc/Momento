<?php
/**
 * EventHandlerInterface.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Handles events with either simple processing or delegating complex tasks to a
 * proper service or model.
 *
 * @author George D. Cooksey, III
 */
interface EventHandlerInterface
{
    /**
     * Process or delegate an {@link EventInterface}
     *
     * @param  Event $anEvent the event to handle
     * @return void
     */
    public function handle(EventInterface $anEvent);

    /**
     * List the handled event types
     *
     * @return string[]
     */
    public function listHandledEventTypes();
}

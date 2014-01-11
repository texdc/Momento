<?php
/**
 * EventHandler.php
 *
 * @copyright 2013 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Handles events with either simple processing or delegating complex tasks to a
 * proper service or model.
 *
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
interface EventHandler
{
    /**
     * Handle an {@link Event}
     *
     * @param  Event $event the event to handle
     * @return bool false to halt further processing, true to continue
     */
    public function handle(Event $event);

    /**
     * List the handled event types
     *
     * @return array
     */
    public function listHandledEventTypes();
}

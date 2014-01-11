<?php
/**
 * EventHandler.php
 *
 * @copyright 2013 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * An {@link Event} observer
 *
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
interface EventHandler
{
    /**
     * Handle a {@link Event}
     *
     * @param Event $event the event to handle
     */
    public function handle(Event $event);

    /**
     * List the handled event types
     *
     * @return array
     */
    public function listHandledEventTypes();
}

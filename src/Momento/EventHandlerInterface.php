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
     * @param EventInterface $anEvent the event to handle
     */
    public function __invoke(EventInterface $anEvent);

    /**
     * List the events that are valid for this handler
     *
     * @return string[]
     */
    public function validEventTypes();

    /**
     * Verify a handled event type
     *
     * @param  string $anEventType the event type to verify
     * @return bool
     */
    public static function validateEventType($anEventType);
}

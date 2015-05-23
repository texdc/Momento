<?php
/**
 * EventHandlerInterface.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Handles events with either simple processing or delegating complex tasks to a
 * proper service or model.
 *
 * @author George D. Cooksey, III
 */
interface EventHandlerInterface extends LimitsEventTypesInterface
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
     * Register this handler to an event publisher
     *
     * @param  EventPublisherInterface $aPublisher
     * @return void
     */
    public function registerTo(EventPublisherInterface $aPublisher);
}

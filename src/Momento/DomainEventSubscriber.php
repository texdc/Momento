<?php
/**
 * DomainEventSubscriber.php
 *
 * @copyright 2013 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * A {@link DomainEvent} observer
 *
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
interface DomainEventSubscriber
{
    /**
     * Handle a {@link DomainEvent}
     *
     * @param DomainEvent $event the event to handle
     */
    public function handle(DomainEvent $event);

    /**
     * List the handled event types
     *
     * @return array
     */
    public function listHandledEventTypes();
}

<?php
/**
 * EventPublisherInterface.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Publishers publish events to their registered handlers
 *
 * @author George D. Cooksey, III
 */
interface EventPublisherInterface
{
    /**
     * @var string
     */
    const EVENT_TYPE_ALL = '*';

    /**
     * Publish an event
     *
     * @param  EventInterface $anEvent
     * @return void
     */
    public function publish(EventInterface $anEvent);

    /**
     * Register an event handler
     *
     * @param  callable $aHandler
     * @return void
     */
    public function register(callable $aHandler);
}

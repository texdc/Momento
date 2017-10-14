<?php
/**
 * EventPublisherInterface.php
 *
 * @copyright 2017 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento;

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
     * @param EventInterface $anEvent the event to publish
     */
    public function publish(EventInterface $anEvent);
}

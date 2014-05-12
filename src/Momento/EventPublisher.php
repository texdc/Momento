<?php
/**
 * EventPublisher.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

use Momento\Exception\InvalidEventTypeException;

/**
 * Manages a prioritized set of {@link EventHandlerInterface} instances by event type.
 *
 * @author George D. Cooksey, III
 */
class EventPublisher implements EventPublisherInterface
{
    /**
     * @var string[]
     */
    protected static $defaultEventTypes = [self::EVENT_TYPE_ALL];

    /**
     * @var HandlerQueue[]
     */
    protected $queues = [];

    /**
     * Constructor
     *
     * If $handlers is multi-dimensional, the inner array(s) must have two keys,
     * handler and priority.
     *
     * @param callable[] $handlers the handlers to register
     */
    public function __construct(array $handlers)
    {
        foreach ($handlers as $handler) {
            $priority = 0;
            if (is_array($handler)) {
                extract($handler, EXTR_OVERWRITE);
            }
            $this->register($handler, $priority);
        }
    }

    /**
     * Publish an event
     *
     * @param Event $anEvent the event to publish
     */
    public function publish(EventInterface $anEvent)
    {
        foreach ($this->initQueue($anEvent->eventType(), []) as $handler) {
            $handler($anEvent);
        }
        foreach ($this->initQueue() as $handler) {
            $handler($anEvent);
        }
    }

    /**
     * Register a handler
     *
     * @param callable $aHandler     the handler to register
     * @param int      $withPriority the handler's priority
     */
    private function register(callable $aHandler, $withPriority = 0)
    {
        $eventTypes = ($aHandler instanceof EventHandlerInterface)
            ? $aHandler->validEventTypes()
            : static::$defaultEventTypes;

        foreach ($eventTypes as $eventType) {
            $this->initQueue($eventType)->insert($aHandler, $withPriority);
        }
    }

    /**
     * Initialize an event handler queue
     *
     * @param  string $anEventType the event type to queue
     * @param  array  $queue       a default queue to initialize
     * @return HandlerQueue|array
     */
    private function initQueue($anEventType = self::EVENT_TYPE_ALL, array $queue = null)
    {
        if (!isset($this->queues[$anEventType])) {
            $this->queues[$anEventType] = $queue ?: new HandlerQueue;
        }
        return $this->queues[$anEventType];
    }
}

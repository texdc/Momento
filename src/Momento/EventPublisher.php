<?php
/**
 * EventPublisher.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Manages a prioritized set of {@link EventHandlerInterface} instances or callables
 * by event type.
 *
 * @author George D. Cooksey, III
 */
final class EventPublisher implements EventPublisherInterface
{
    /**
     * @var string[]
     */
    private $defaultEventTypes;

    /**
     * @var HandlerQueue[]
     */
    private $queues = [];

    /**
     * Constructor
     *
     * If $handlers is multi-dimensional, the inner array(s) must have two keys,
     * handler and priority.
     *
     * @param callable[] $handlers          the handlers to register
     * @param string[]   $defaultEventTypes the default event types
     */
    public function __construct(array $handlers, array $defaultEventTypes = [self::EVENT_TYPE_ALL])
    {
        $this->defaultEventTypes = $defaultEventTypes;
        foreach ($handlers as $handler) {
            $priority = 0;
            if (is_array($handler)) {
                extract($handler, EXTR_OVERWRITE);
            }
            if (!is_callable($handler) && is_string($handler) && class_exists($handler)) {
                $handler = $this->buildHandlerProxy($handler);
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
            : $this->defaultEventTypes;

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

    /**
     * Build a handler proxy
     *
     * The class name must be an implementation of the {@link EventHandlerInterface},
     * or implement the '(@link __invoke}' magic method.  It must also not require
     * any constructor arguments.
     *
     * The handler will not be instanciated until needed, and then only once by being
     * stored in a static variable.
     *
     * @param  string $className the handler's classname
     * @return callable
     */
    private function buildHandlerProxy($className)
    {
        return function (EventInterface $anEvent) use ($className) {
            static $handler;
            if (!isset($handler)) {
                $handler = new $className;
            }
            $handler($anEvent);
        };
    }
}

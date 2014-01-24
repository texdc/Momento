<?php
/**
 * HandlerTrait.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * A basic implementation of the {@link EventHandler} interface
 * 
 * @package Momento
 */
trait HandlerTrait
{
    /**
     * @var string[]
     */
    private $handledEventTypes = [];
    
    /**
     * @param  Event            $anEvent      the event to handle
     * @param  EventResult|null $aPriorResult optional result from a prior handler
     * @return EventResult
     */
    abstract public function handle(Event $anEvent, EventResult $aPriorResult = null);
    
    /**
     * Is an event type handled?
     * 
     * @param  string $anEventType the event type to check
     * @return bool
     */
    public function handles($anEventType)
    {
        return in_array($anEventType, $this->handledEventTypes);
    }
    
    /**
     * @return string[]
     */
    public function listHandledEventTypes()
    {
        return $this->handledEventTypes;
    }
    
    /**
     * @param  Event $anEvent the event to validate
     * @return void
     * @throws Exception\InvalidEventException
     */
    private function validate(Event $anEvent)
    {
        if (!$this->handles($anEvent->eventType())) {
            throw new Exception\InvalidEventException($anEvent);
        }
    }
}

<?php

namespace MomentoTest\TestAsset;

use Momento\Event;
use Momento\EventHandler;
use Momento\EventHandlerTrait;
use Momento\EventResult;

class TestEventHandler implements EventHandler
{
    use EventHandlerTrait;

    public function __construct(array $handledEventTypes = [])
    {
        $this->setHandledEventTypes($handledEventTypes);
    }

    public function handle(Event $anEvent, EventResult $aPriorResult = null)
    {
        $this->validate($anEvent);
        return new TestResult($anEvent);
    }
}

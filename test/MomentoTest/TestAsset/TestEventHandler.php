<?php
/**
 * TestEventHandler.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest\TestAsset;

use Momento\EventHandlerInterface as EventHandler;
use Momento\EventHandlerTrait;
use Momento\EventInterface as Event;

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
    }
}

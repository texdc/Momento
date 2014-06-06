<?php
/**
 * TestEventHandler.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest\TestAsset;

use Momento\AbstractEventHandler;
use Momento\EventInterface as Event;

class TestEventHandler extends AbstractEventHandler
{
    const EVENT_TYPE_TEST = 'test';

    protected static $validEventTypes = [
        self::EVENT_TYPE_TEST
    ];

    public function __invoke(Event $anEvent)
    {
        $this->guardValidEventType($anEvent->eventType());
    }
}

<?php
/**
 * EventHandler.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\test\asset;

use texdc\momento\AbstractEventHandler;
use texdc\momento\EventInterface as Event;

class EventHandler extends AbstractEventHandler
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

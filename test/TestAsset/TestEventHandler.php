<?php
/**
 * TestEventHandler.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest\TestAsset;

use Momento\AbstractEventHandler;
use Momento\EventInterface as Event;
use Momento\EventPublisherInterface;

class TestEventHandler extends AbstractEventHandler
{
    const EVENT_TYPE_TEST = 'test';

    protected static $validEventTypes = [
        self::EVENT_TYPE_TEST
    ];

    public function __invoke(Event $anEvent)
    {
        $this->guardEventType($anEvent->eventType());
    }

    public function registerTo(EventPublisherInterface $aPublisher)
    {
        $aPublisher->register($this, static::$validEventTypes);
    }
}

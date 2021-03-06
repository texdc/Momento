<?php
/**
 * EventPublisherTest.php
 *
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 2017 George D. Cooksey, III
 */

namespace texdc\momento\test;

use texdc\momento\EventPublisher;

use PHPUnit\Framework\TestCase;
use texdc\momento\EventInterface;

class EventPublisherTest extends TestCase
{
    const EVENT_TYPE_TEST = 'test';
    const EVENT_TYPE_FOO  = 'foo';

    public function testClassExists()
    {
        $this->assertTrue(class_exists('texdc\momento\EventPublisher'));
    }

    public function testConstructorWithHandlerArray()
    {
        $event    = $this->buildEvent();

        $handler1 = $this->buildHandler([self::EVENT_TYPE_FOO]);
        $handler1
            ->expects($this->never())
            ->method('__invoke');

        $handler2 = $this->buildHandler();
        $handler2
            ->expects($this->once())
            ->method('__invoke')
            ->with($event);

        $subject  = new EventPublisher([
            ['handler' => $handler1, 'priority' => 1],
            ['handler' => $handler2, 'priority' => 5],
        ]);

        $subject->publish($event);
    }

    public function testConstructorBuildsProxyHandlerForClassString()
    {
        $subject = new EventPublisher(['texdc\momento\test\asset\EventHandler']);
        $event   = $this->buildEvent(static::EVENT_TYPE_FOO);
        $this->expectException('texdc\momento\exception\EventException');
        $subject->publish($event);
    }

    public function testPublishDispatchesUnknownEventTypeToGenericHandlers()
    {
        $event   = $this->buildEvent(self::EVENT_TYPE_FOO);
        $test    = $this;
        $handler = function (EventInterface $anEvent) use ($test, $event) {
            $test->assertSame($event, $anEvent);
        };

        $subject = new EventPublisher([$handler]);
        $subject->publish($event);
    }

    private function buildHandler(array $validEventTypes = [self::EVENT_TYPE_TEST])
    {
        $handler = $this->getMockForAbstractClass('texdc\momento\EventHandlerInterface');
        $handler
            ->expects($this->any())
            ->method('validEventTypes')
            ->will($this->returnValue($validEventTypes));
        return $handler;
    }

    private function buildEvent($anEventType = self::EVENT_TYPE_TEST)
    {
        $event = $this->getMockForAbstractClass('texdc\momento\EventInterface');
        $event
            ->expects($this->any())
            ->method('eventType')
            ->will($this->returnValue($anEventType));
        return $event;
    }
}

<?php
/**
 * EventPublisherTest.php
 *
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 2014 George D. Cooksey, III
 */

namespace MomentoTest;

use Momento\EventPublisher;
use MomentoTest\TestAsset\TestResult;

use PHPUnit_Framework_TestCase as TestCase;

class EventPublisherTest extends TestCase
{

    public function testClassExists()
    {
        $this->assertTrue(class_exists('Momento\EventPublisher'));
    }

    public function testHandlersListIsArray()
    {
        $subject = new EventPublisher;
        $this->assertInternalType('array', $subject->listRegisteredHandlers());
    }

    public function testRegisterRegistersHandler()
    {
        $handler = $this->buildHandler();
        $subject = new EventPublisher;
        $subject->register($handler);
        $this->assertContains($handler, $subject->listRegisteredHandlers('test'));
    }

    public function testConstructorWithHandlerArray()
    {
        $handler1 = $this->buildHandler(['foo']);
        $handler2 = $this->buildHandler();
        $subject  = new EventPublisher([
            ['handler' => $handler1, 'priority' => 1],
            ['handler' => $handler2, 'priority' => 5],
        ]);

        $handlers = $subject->listRegisteredHandlers();
        $this->assertArrayHasKey('foo', $handlers);
        $this->assertArrayHasKey('test', $handlers);
    }

    public function testUnregisterRemovesHandler()
    {
        $handler = $this->buildHandler();
        $subject = new EventPublisher;
        $subject->register($handler);
        $subject->unregister($handler);
        $this->assertNotContains($handler, $subject->listRegisteredHandlers('test'));
    }

    public function testPublishDispatchesEventToItsHandlers()
    {
        $event = $this->getMockForAbstractClass('Momento\Event');
        $event
            ->expects($this->once())
            ->method('eventType')
            ->will($this->returnValue('test'));

        $handler1 = $this->buildHandler(['foo']);
        $handler1
            ->expects($this->never())
            ->method('handle');

        $handler2 = $this->buildHandler();
        $handler2
            ->expects($this->once())
            ->method('handle')
            ->with($event)
            ->will($this->returnValue(new TestResult($event)));

        $subject = new EventPublisher([$handler1, $handler2]);
        $subject->publish($event);
    }

    public function testStoppedEventPreventsPropagation()
    {
        $event = $this->getMockForAbstractClass('Momento\Event');
        $event
            ->expects($this->once())
            ->method('eventType')
            ->will($this->returnValue('test'));

        $handler1 = $this->buildHandler();
        $handler1
            ->expects($this->once())
            ->method('handle')
            ->with($event)
            ->will($this->returnValue(new TestResult($event, true)));

        $handler2 = $this->buildHandler();
        $handler2
            ->expects($this->never())
            ->method('handle');

        $subject = new EventPublisher([$handler1, $handler2]);
        $subject->publish($event);
    }

    private function buildHandler(array $handledEventTypes = ['test'])
    {
        $handler = $this->getMockForAbstractClass('Momento\EventHandler');
        $handler
            ->expects($this->any())
            ->method('listHandledEventTypes')
            ->will($this->returnValue($handledEventTypes));
        return $handler;
    }
}

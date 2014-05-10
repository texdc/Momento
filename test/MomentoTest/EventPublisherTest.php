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
    private $validEventTypes = ['test', 'foo'];

    public function testClassExists()
    {
        $this->assertTrue(class_exists('Momento\EventPublisher'));
    }

    public function testListValidEventTypesReturnsDefinedEventTypes()
    {
        $subject = new EventPublisher($this->validEventTypes);
        $this->assertSame($this->validEventTypes, $subject->listValidEventTypes());
    }

    public function testListRegisteredHandlersReturnsArray()
    {
        $subject = new EventPublisher($this->validEventTypes);
        $this->assertInternalType('array', $subject->listRegisteredHandlers());
    }

    public function testRegisterRegistersHandler()
    {
        $handler = $this->buildHandler();
        $subject = new EventPublisher($this->validEventTypes);
        $subject->register($handler);
        $this->assertContains($handler, $subject->listRegisteredHandlers('test'));
    }

    public function testRegisterHandlerWithUnsupportedEventTypeIsRegistered()
    {
        $handler = $this->buildHandler(['error', 'test']);
        $subject = new EventPublisher($this->validEventTypes);
        $subject->register($handler);
        $this->assertContains($handler, $subject->listRegisteredHandlers('test'));
    }

    public function testConstructorWithHandlerArray()
    {
        $handler1 = $this->buildHandler(['foo']);
        $handler2 = $this->buildHandler();
        $subject  = new EventPublisher($this->validEventTypes, [
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
        $subject = new EventPublisher($this->validEventTypes);
        $subject->register($handler);
        $subject->unregister($handler);
        $this->assertNotContains($handler, $subject->listRegisteredHandlers('test'));
    }

    public function testDisableGuardsForValidEventType()
    {
        $subject = new EventPublisher($this->validEventTypes);
        $this->setExpectedException(
            'Momento\Exception\InvalidEventTypeException',
            'Invalid event type [error]'
        );
        $subject->disable('error');
    }

    public function testDisableEventType()
    {
        $subject = new EventPublisher($this->validEventTypes);
        $subject->disable('foo');
        $this->assertNotContains('foo', $subject->listEnabledEventTypes());
        $this->assertContains('foo', $subject->listDisabledEventTypes());
    }

    public function testEnableGuardsForValidEventType()
    {
        $subject = new EventPublisher($this->validEventTypes);
        $this->setExpectedException(
            'Momento\Exception\InvalidEventTypeException',
            'Invalid event type [error]'
        );
        $subject->enable('error');
    }

    public function testEnableEventType()
    {
        $subject = new EventPublisher($this->validEventTypes);
        $subject->disable('foo');
        $subject->enable('foo');
        $this->assertContains('foo', $subject->listEnabledEventTypes());
        $this->assertNotContains('foo', $subject->listDisabledEventTypes());
    }

    public function testPublishDispatchesEventToItsHandlers()
    {
        $event = $this->getMockForAbstractClass('Momento\EventInterface');
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
            ->with($event);

        $subject = new EventPublisher($this->validEventTypes, [$handler1, $handler2]);
        $subject->publish($event);
    }

    public function testPublishRequiresEnabledEventType()
    {
        $event = $this->getMockForAbstractClass('Momento\EventInterface');
        $event
            ->expects($this->once())
            ->method('eventType')
            ->will($this->returnValue('foo'));

        $subject = new EventPublisher($this->validEventTypes);
        $subject->disable('foo');
        $this->setExpectedException(
            'Momento\Exception\InvalidEventTypeException',
            'Disabled event type [foo]'
        );
        $subject->publish($event);
    }

    private function buildHandler(array $handledEventTypes = ['test'])
    {
        $handler = $this->getMockForAbstractClass('Momento\EventHandlerInterface');
        $handler
            ->expects($this->any())
            ->method('listHandledEventTypes')
            ->will($this->returnValue($handledEventTypes));
        return $handler;
    }
}

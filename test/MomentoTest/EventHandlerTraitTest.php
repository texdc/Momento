<?php

namespace MomentoTest;

use PHPUnit_Framework_TestCase as TestCase;
use MomentoTest\TestAsset\TestEventHandler;

class EventHandlerTraitTest extends TestCase
{
    private static $traitClassname = 'Momento\EventHandlerTrait';

    public function testTraitExists()
    {
        $this->assertTrue(trait_exists(static::$traitClassname));
    }

    public function testListHandledEventTypesReturnsArray()
    {
        $subject = new TestEventHandler(['test']);
        $eventTypes = $subject->listHandledEventTypes();
        $this->assertInternalType('array', $eventTypes);
        $this->assertEquals(['test'], $eventTypes);
    }

    public function testHandlesReturnsBool()
    {
        $subject = new TestEventHandler(['test']);
        $this->assertTrue($subject->handles('test'));
        $this->assertFalse($subject->handles('foo'));
    }

    public function testValidateThrowsException()
    {
        $this->setExpectedException('Momento\Exception\InvalidEventTypeException');
        $subject = new TestEventHandler(['test']);
        $event = $this->getMockForAbstractClass('Momento\Event');
        $event
            ->expects($this->once())
            ->method('eventType')
            ->will($this->returnValue('foo'));
        $subject->handle($event);
    }

    public function testValidatePassesValidEventType()
    {
        $subject = new TestEventHandler(['test']);
        $event = $this->getMockForAbstractClass('Momento\Event');
        $event
            ->expects($this->once())
            ->method('eventType')
            ->will($this->returnValue('test'));
        $this->assertInstanceOf('Momento\EventResult', $subject->handle($event));
    }
}

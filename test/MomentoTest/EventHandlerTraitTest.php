<?php
/**
 * EventHandlerTraitTest.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest;

use PHPUnit_Framework_TestCase as TestCase;
use MomentoTest\TestAsset\TestEventHandler;

/**
 * @covers \Momento\EventHandlerTrait
 */
class EventHandlerTraitTest extends TestCase
{
    public function testTraitExists()
    {
        $this->assertTrue(trait_exists('Momento\EventHandlerTrait'));
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
            ->method('getType')
            ->will($this->returnValue('foo'));
        $subject->handle($event);
    }

    public function testValidatePassesValidEventType()
    {
        $subject = new TestEventHandler(['test']);
        $event = $this->getMockForAbstractClass('Momento\Event');
        $event
            ->expects($this->once())
            ->method('getType')
            ->will($this->returnValue('test'));
        $subject->handle($event);
    }
}

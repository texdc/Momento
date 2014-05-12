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

    public function testValidEventTypesReturnsArray()
    {
        $subject = new TestEventHandler;
        $eventTypes = $subject->validEventTypes();
        $this->assertInternalType('array', $eventTypes);
        $this->assertEquals([$subject::EVENT_TYPE_TEST], $eventTypes);
    }

    public function testValidateEventTypeReturnsBool()
    {
        $subject = new TestEventHandler;
        $this->assertFalse($subject::validateEventType('foo'));
    }

    public function testGuardValidEventTypeThrowsException()
    {
        $this->setExpectedException('Momento\Exception\InvalidEventTypeException');
        $subject = new TestEventHandler;
        $subject($this->buildEvent('foo'));
    }

    public function testGuardValidEventTypePassesValidEventType()
    {
        $subject = new TestEventHandler;
        $subject($this->buildEvent($subject::EVENT_TYPE_TEST));
    }

    private function buildEvent($anEventType)
    {
        $event = $this->getMockForAbstractClass('Momento\EventInterface');
        $event
            ->expects($this->once())
            ->method('eventType')
            ->will($this->returnValue($anEventType));
        return $event;
    }
}

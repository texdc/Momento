<?php
/**
 * AbstractEventHandlerTest.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest;

use PHPUnit_Framework_TestCase as TestCase;
use MomentoTest\TestAsset\TestEventHandler;

/**
 * @covers \Momento\AbstractEventHandler
 */
class AbstractEventHandlerTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Momento\AbstractEventHandler'));
    }

    public function testInstanceOfEventHandlerInterface()
    {
        $subject = $this->getMockForAbstractClass('Momento\AbstractEventHandler');
        $this->assertInstanceOf('Momento\EventHandlerInterface', $subject);
    }

    public function testValidEventTypesReturnsArray()
    {
        $subject    = new TestEventHandler;
        $eventTypes = $subject->validEventTypes();
        $this->assertInternalType('array', $eventTypes);
        $this->assertEquals([$subject::EVENT_TYPE_TEST], $eventTypes);
    }

    public function testAcceptsEventTypeReturnsBool()
    {
        $subject = new TestEventHandler;
        $this->assertFalse($subject->acceptsEventType('foo'));
    }

    public function testGuardEventTypeThrowsException()
    {
        $this->setExpectedException('Momento\Exception\InvalidEventTypeException');
        $subject = new TestEventHandler;
        $subject($this->buildEvent('foo'));
    }

    public function testGuardEventTypePassesValidEventType()
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

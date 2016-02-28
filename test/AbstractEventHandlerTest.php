<?php
/**
 * AbstractEventHandlerTest.php
 *
 * @copyright 2016 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\test;

use PHPUnit_Framework_TestCase as TestCase;
use texdc\momento\test\asset\EventHandler;

/**
 * @covers texdc\momento\AbstractEventHandler
 */
class AbstractEventHandlerTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('texdc\momento\AbstractEventHandler'));
    }

    public function testInstanceOfEventHandlerInterface()
    {
        $subject = $this->getMockForAbstractClass('texdc\momento\AbstractEventHandler');
        $this->assertInstanceOf('texdc\momento\EventHandlerInterface', $subject);
    }

    public function testValidEventTypesReturnsArray()
    {
        $subject    = new EventHandler;
        $eventTypes = $subject->validEventTypes();
        $this->assertInternalType('array', $eventTypes);
        $this->assertEquals([$subject::EVENT_TYPE_TEST], $eventTypes);
    }

    public function testValidateEventTypeReturnsBool()
    {
        $subject = new EventHandler;
        $this->assertFalse($subject::validateEventType('foo'));
    }

    public function testGuardValidEventTypeThrowsException()
    {
        $this->setExpectedException('texdc\momento\exception\EventException');
        $subject = new EventHandler;
        $subject($this->buildEvent('foo'));
    }

    public function testGuardValidEventTypePassesValidEventType()
    {
        $subject = new EventHandler;
        $subject($this->buildEvent($subject::EVENT_TYPE_TEST));
    }

    private function buildEvent($anEventType)
    {
        $event = $this->getMockForAbstractClass('texdc\momento\EventInterface');
        $event
            ->expects($this->once())
            ->method('eventType')
            ->will($this->returnValue($anEventType));
        return $event;
    }
}

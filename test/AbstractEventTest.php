<?php
/**
 * AbstractEventTest.php
 *
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 2015 George D. Cooksey, III
 */

namespace texdc\momento\test;

use PHPUnit_Framework_TestCase as TestCase;

class AbstractEventTest extends TestCase
{
    /**
     * @var texdc\momento\AbstractEvent
     */
    private $event;

    protected function setUp()
    {
        $this->event = $this->getMockForAbstractClass('texdc\momento\AbstractEvent');
    }

    public function testEventId()
    {
        $this->assertInstanceOf('texdc\momento\EventId', $this->event->eventId());
    }

    public function testSetEventIdThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid event type [test]');
        $eventId = $this->getMock('texdc\momento\EventId', null, array('test'));
        $event   = $this->getMockForAbstractClass('texdc\momento\AbstractEvent', array($eventId));
    }

    public function testOccurrenceDateReturnsDateTime()
    {
        $this->assertInstanceOf('DateTime', $this->event->occurrenceDate());
    }

    public function testEventTypeReturnsString()
    {
        $this->assertInternalType('string', $this->event->eventType());
    }

    public function testEqualsComparesEventId()
    {
        $other = $this->getMockForAbstractClass('texdc\momento\AbstractEvent');
        $this->assertFalse($this->event->equals($other));
    }
}

<?php
/**
 * AbstractEventTest.php
 *
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 2014 George D. Cooksey, III
 */

namespace MomentoTest;

use PHPUnit_Framework_TestCase as TestCase;

class AbstractEventTest extends TestCase
{
    /**
     * @var \Momento\AbstractEvent
     */
    private $event;

    protected function setUp()
    {
        $this->event = $this->getMockForAbstractClass('Momento\AbstractEvent');
    }

    public function testEventId()
    {
        $this->assertInstanceOf('Momento\EventId', $this->event->eventId());
    }

    public function testSetEventIdThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid event type [test]');
        $eventId = $this->getMock('Momento\EventId', null, array('test'));
        $event   = $this->getMockForAbstractClass('Momento\AbstractEvent', array($eventId));
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
        $other = $this->getMockForAbstractClass('Momento\AbstractEvent');
        $this->assertFalse($this->event->equals($other));
    }
}

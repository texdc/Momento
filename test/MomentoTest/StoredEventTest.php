<?php
/**
 * StoredEventTest.php
 *
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 2014 George D. Cooksey, III
 */

namespace MomentoTest;

use DateTime;
use Momento\StoredEvent;
use PHPUnit_Framework_TestCase as TestCase;

class StoredEventTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Momento\StoredEvent'));
    }

    public function testEventIdReturnsInt()
    {
        $event = $this->getMockForAbstractClass('Momento\EventInterface');
        $subject = new StoredEvent($event);
        $this->assertInternalType('int', $subject->eventId());
    }

    public function testOccurredOnReturnsEventsOccurredOnDate()
    {
        $expectedDate = new DateTime;
        $event = $this->getMockForAbstractClass('Momento\EventInterface');
        $event
            ->expects($this->once())
            ->method('occurrenceDate')
            ->will($this->returnValue($expectedDate));

        $subject = new StoredEvent($event);
        $this->assertSame($expectedDate, $subject->getOcurrenceDate());
    }

    public function testToDomainEventReturnsContainedEvent()
    {
        $event = $this->getMockForAbstractClass('Momento\EventInterface');
        $subject = new StoredEvent($event);
        $this->assertSame($event, $subject->toEvent());
    }

    public function testEventTypeReturnsContainedEventType()
    {
        $event = $this->getMockForAbstractClass('Momento\EventInterface');
        $event
            ->expects($this->once())
            ->method('eventType')
            ->will($this->returnValue('test'));
        $subject = new StoredEvent($event);
        $this->assertEquals('test', $subject->getType());
    }

    public function testEqualsComparesEventId()
    {
        $event1  = $this->getMockForAbstractClass('Momento\EventInterface');
        $event2  = $this->getMockForAbstractClass('Momento\EventInterface');
        $subject = new StoredEvent($event1);
        $other   = new StoredEvent($event2);
        $this->assertTrue($subject->equals($other));
    }

    public function testToStringReturnsFormattedString()
    {
        $event      = $this->getMockForAbstractClass('Momento\EventInterface');
        $eventClass = get_class($event);
        $subject    = new StoredEvent($event);
        $expected   = "StoredEvent [eventId=0, event=$eventClass]";
        $this->assertSame($expected, (string) $subject);
    }
}

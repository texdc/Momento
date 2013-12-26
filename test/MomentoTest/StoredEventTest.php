<?php
/**
 * StoredEventTest.php
 *
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 2013 George D. Cooksey, III
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
        $event = $this->getMockForAbstractClass('Momento\DomainEvent');
        $subject = new StoredEvent($event);
        $this->assertInternalType('int', $subject->eventId());
    }

    public function testOccurredOnReturnsEventsOccurredOnDate()
    {
        $expectedDate = new DateTime;
        $event = $this->getMockForAbstractClass('Momento\DomainEvent');
        $event
            ->expects($this->once())
            ->method('occurredOn')
            ->will($this->returnValue($expectedDate));

        $subject = new StoredEvent($event);
        $this->assertSame($expectedDate, $subject->occurredOn());
    }

    public function testToDomainEventReturnsContainedEvent()
    {
        $event = $this->getMockForAbstractClass('Momento\DomainEvent');
        $subject = new StoredEvent($event);
        $this->assertSame($event, $subject->toDomainEvent());
    }

    public function testTypeNameReturnsContainedEventClassname()
    {
        $event = $this->getMockForAbstractClass('Momento\DomainEvent');
        $subject = new StoredEvent($event);
        $this->assertEquals(get_class($event), $subject->typeName());
    }

    public function testEqualsComparesEventId()
    {
        $event1 = $this->getMockForAbstractClass('Momento\DomainEvent');
        $event2 = $this->getMockForAbstractClass('Momento\DomainEvent');
        $subject = new StoredEvent($event1);
        $other = new StoredEvent($event2);
        $this->assertTrue($subject->equals($other));
    }

    public function testToStringReturnsFormattedString()
    {
        $event = $this->getMockForAbstractClass('Momento\DomainEvent');
        $event
            ->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('MockDomainEvent'));

        $subject = new StoredEvent($event);
        $expected = 'StoredEvent [eventId=0, event=MockDomainEvent]';
        $this->assertSame($expected, (string) $subject);
    }
}

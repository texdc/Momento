<?php
/**
 * AbstractEventTest.php
 *
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 2016 George D. Cooksey, III
 */

namespace texdc\momento\test;

use texdc\momento\EventId;
use PHPUnit\Framework\TestCase;

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
        $this->expectException('texdc\momento\exception\EventException', 'Invalid event type [test]');
        $eventId = $this->getMockBuilder(EventId::class)
                        ->setConstructorArgs(['test'])
                        ->getMock();
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
}

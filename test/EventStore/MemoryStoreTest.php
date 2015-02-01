<?php

namespace MomentoTest\EventStore;

use PHPUnit_Framework_TestCase as TestCase;
use Momento\EventStore\MemoryStore;
use Momento\EventId;

class MemoryStoreTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Momento\EventStore\MemoryStore'));
    }

    public function testImplementsEventStoreInterface()
    {
        $this->assertInstanceOf('Momento\EventStoreInterface', new MemoryStore);
    }

    public function testAppendAddsEvent()
    {
        $subject = new MemoryStore;
        $this->assertCount(0, $subject);
        $subject->append($this->getEvent());
        $this->assertCount(1, $subject);
    }

    public function testAppendRejectsDuplicates()
    {
        $subject = new MemoryStore;
        $event = $this->getEvent();
        $subject->append($event);
        $this->setExpectedException('Momento\Exception\AppendingPreventedException');
        $subject->append($event);
    }

    public function testAllSinceReturnsEventArray()
    {
        $numEvents = 0;
        $anEventId;
        $subject = new MemoryStore;
        while ($numEvents <= 5) {
            $event = $this->getEvent();
            if ($numEvents == 2) {
                $anEventId = $event->eventId();
            }
            $subject->append($event);
            $numEvents++;
        }
        $allSince = $subject->allSince($anEventId);
        $this->assertInternalType('array', $allSince);
        $this->assertCount(3, $allSince);
    }

    public function testAllBetweenReturnsEventArray()
    {
        $numEvents = 0;
        $aLowEventId;
        $aHighEventId;
        $subject = new MemoryStore;
        while ($numEvents <= 5) {
            $event = $this->getEvent();
            if ($numEvents == 2) {
                $aLowEventId = $event->eventId();
            } elseif ($numEvents == 4) {
                $aHighEventId = $event->eventId();
            }
            $subject->append($event);
            $numEvents++;
        }
        $allBetween = $subject->allBetween($aLowEventId, $aHighEventId);
        $this->assertInternalType('array', $allBetween);
        $this->assertCount(1, $allBetween);
    }

    /**
     * @return \Momento\EventInterface
     */
    protected function getEvent()
    {
        $event = $this->getMockForAbstractClass('Momento\EventInterface');
        $event
            ->expects($this->any())
            ->method('eventId')
            ->will($this->returnValue(new EventId(__CLASS__)))
        ;
        return $event;
    }
}

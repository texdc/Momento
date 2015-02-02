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

    public function testExtendsAbstractTypeRestrictedStore()
    {
        $this->assertInstanceOf(
            'Momento\EventStore\AbstractTypeRestrictedStore',
            new MemoryStore(__CLASS__)
        );
    }

    public function testAppendAddsEvent()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->assertCount(0, $subject);
        $subject->append($this->getEvent());
        $this->assertCount(1, $subject);
    }

    public function testAppendValidatesEventType()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->setExpectedException('Momento\Exception\InvalidEventTypeException');
        $subject->append($this->getEvent('foo'));
    }

    public function testAppendRejectsDuplicates()
    {
        $subject = new MemoryStore(__CLASS__);
        $event = $this->getEvent();
        $subject->append($event);
        $this->setExpectedException('Momento\Exception\AppendingPreventedException');
        $subject->append($event);
    }

    public function testFindAllSinceReturnsEventArray()
    {
        $numEvents = 0;
        $anEventId;
        $subject = new MemoryStore(__CLASS__);
        while ($numEvents <= 5) {
            $event = $this->getEvent();
            if ($numEvents == 2) {
                $anEventId = $event->eventId();
            }
            $subject->append($event);
            $numEvents++;
        }
        $findAllSince = $subject->findAllSince($anEventId);
        $this->assertInternalType('array', $findAllSince);
        $this->assertCount(3, $findAllSince);
    }

    public function testFindAllSinceValidatesEventType()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->setExpectedException('Momento\Exception\InvalidEventTypeException');
        $subject->findAllSince(new EventId('foo'));
    }

    public function testFindAllBetweenReturnsEventArray()
    {
        $numEvents = 0;
        $aLowEventId;
        $aHighEventId;
        $subject = new MemoryStore(__CLASS__);
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
        $findAllBetween = $subject->findAllBetween($aLowEventId, $aHighEventId);
        $this->assertInternalType('array', $findAllBetween);
        $this->assertCount(1, $findAllBetween);
    }

    public function testFindAllBetweenValidatesLowEventType()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->setExpectedException('Momento\Exception\InvalidEventTypeException');
        $subject->findAllBetween(new EventId('foo'), new EventId(__CLASS__));
    }

    public function testFindAllBetweenValidatesHighEventType()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->setExpectedException('Momento\Exception\InvalidEventTypeException');
        $subject->findAllBetween(new EventId(__CLASS__), new EventId('foo'));
    }

    public function testFindByIdValidatesEventType()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->setExpectedException('Momento\Exception\InvalidEventTypeException');
        $subject->findById(new EventId('foo'));
    }

    public function testFindByIdReturnsEventInterface()
    {
        $subject = new MemoryStore(__CLASS__);
        $event   = $this->getEvent();
        $subject->append($event);
        $this->assertSame($event, $subject->findById($event->eventId()));
    }

    public function testFindByIdThrowsUnknownEventIdException()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->setExpectedException('Momento\Exception\UnknownEventIdException');
        $subject->findById(new EventId(__CLASS__));
    }

    /**
     * @param  string $anEventType
     * @return \Momento\EventInterface
     */
    protected function getEvent($anEventType = __CLASS__)
    {
        $event = $this->getMockForAbstractClass('Momento\EventInterface');
        $event
            ->expects($this->any())
            ->method('eventId')
            ->will($this->returnValue(new EventId($anEventType)))
        ;
        $event
            ->expects($this->any())
            ->method('eventType')
            ->will($this->returnValue($anEventType))
        ;
        return $event;
    }
}

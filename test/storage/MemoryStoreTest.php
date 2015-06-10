<?php
/**
 * MemoryStoreTest.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\test\storage;

use PHPUnit_Framework_TestCase as TestCase;
use texdc\momento\storage\MemoryStore;
use texdc\momento\EventId;

class MemoryStoreTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('texdc\momento\storage\MemoryStore'));
    }

    public function testExtendsAbstractTypeRestrictedStore()
    {
        $this->assertInstanceOf(
            'texdc\momento\storage\AbstractTypeRestrictedStore',
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
        $this->setExpectedException('texdc\momento\exception\InvalidEventTypeException');
        $subject->append($this->getEvent('foo'));
    }

    public function testAppendRejectsDuplicates()
    {
        $subject = new MemoryStore(__CLASS__);
        $event = $this->getEvent();
        $subject->append($event);
        $this->setExpectedException('texdc\momento\exception\AppendingPreventedException');
        $subject->append($event);
    }

    public function testFindAllSinceReturnsEventArray()
    {
        $numEvents = 0;
        $anEventId = null;
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
        $this->setExpectedException('texdc\momento\exception\InvalidEventTypeException');
        $subject->findAllSince(new EventId('foo'));
    }

    public function testFindAllBetweenReturnsEventArray()
    {
        $numEvents    = 0;
        $aLowEventId  = null;
        $aHighEventId = null;
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
        $this->setExpectedException('texdc\momento\exception\InvalidEventTypeException');
        $subject->findAllBetween(new EventId('foo'), new EventId(__CLASS__));
    }

    public function testFindAllBetweenValidatesHighEventType()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->setExpectedException('texdc\momento\exception\InvalidEventTypeException');
        $subject->findAllBetween(new EventId(__CLASS__), new EventId('foo'));
    }

    public function testFindByIdValidatesEventType()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->setExpectedException('texdc\momento\exception\InvalidEventTypeException');
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
        $this->setExpectedException('texdc\momento\exception\UnknownEventIdException');
        $subject->findById(new EventId(__CLASS__));
    }

    /**
     * @param  string $anEventType
     * @return texdc\momento\EventInterface
     */
    protected function getEvent($anEventType = __CLASS__)
    {
        $event = $this->getMockForAbstractClass('texdc\momento\EventInterface');
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

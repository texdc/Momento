<?php
/**
 * MemoryStoreTest.php
 *
 * @copyright 2016 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\test\storage;

use PHPUnit\Framework\TestCase;
use texdc\momento\storage\MemoryStore;
use texdc\momento\EventId;

class MemoryStoreTest extends TestCase
{
    const EVENT_EXCEPTION   = 'texdc\momento\exception\EventException';
    const STORAGE_EXCEPTION = 'texdc\momento\exception\StorageException';

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

    public function testRecordAddsEvent()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->assertCount(0, $subject);
        $subject->record($this->getEvent());
        $this->assertCount(1, $subject);
    }

    public function testRecordValidatesEventType()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->expectException(self::EVENT_EXCEPTION);
        $subject->record($this->getEvent('foo'));
    }

    public function testRecordRejectsDuplicates()
    {
        $subject = new MemoryStore(__CLASS__);
        $event = $this->getEvent();
        $subject->record($event);
        $this->expectException(static::STORAGE_EXCEPTION);
        $subject->record($event);
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
            $subject->record($event);
            $numEvents++;
        }
        $findAllSince = $subject->findAllSince($anEventId);
        $this->assertInternalType('array', $findAllSince);
        $this->assertCount(3, $findAllSince);
    }

    public function testFindAllSinceValidatesEventType()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->expectException(self::EVENT_EXCEPTION);
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
            $subject->record($event);
            $numEvents++;
        }
        $findAllBetween = $subject->findAllBetween($aLowEventId, $aHighEventId);
        $this->assertInternalType('array', $findAllBetween);
        $this->assertCount(1, $findAllBetween);
    }

    public function testFindAllBetweenValidatesLowEventType()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->expectException(self::EVENT_EXCEPTION);
        $subject->findAllBetween(new EventId('foo'), new EventId(__CLASS__));
    }

    public function testFindAllBetweenValidatesHighEventType()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->expectException(self::EVENT_EXCEPTION);
        $subject->findAllBetween(new EventId(__CLASS__), new EventId('foo'));
    }

    public function testFindByIdValidatesEventType()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->expectException(self::EVENT_EXCEPTION);
        $subject->findById(new EventId('foo'));
    }

    public function testFindByIdReturnsEventInterface()
    {
        $subject = new MemoryStore(__CLASS__);
        $event   = $this->getEvent();
        $subject->record($event);
        $this->assertSame($event, $subject->findById($event->eventId()));
    }

    public function testFindByIdThrowsUnknownEventIdException()
    {
        $subject = new MemoryStore(__CLASS__);
        $this->expectException(static::STORAGE_EXCEPTION);
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

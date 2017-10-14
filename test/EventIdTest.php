<?php
/**
 * EventIdTest.php
 *
 * @copyright 2017 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\test;

use PHPUnit\Framework\TestCase;
use texdc\momento\EventId;

class EventIdTest extends TestCase
{
    /**
     * @var EventId
     */
    private $eventId;

    protected function setUp()
    {
        $this->eventId = new EventId(__CLASS__);
    }

    public function testInstanceOfJsonSerializable()
    {
        $this->assertInstanceOf('JsonSerializable', $this->eventId);
    }

    public function testInstanceOfSerializable()
    {
        $this->assertInstanceOf('Serializable', $this->eventId);
    }

    public function testEventType()
    {
        $this->assertSame(__CLASS__, $this->eventId->eventType());
    }

    public function testOccurrenceDate()
    {
        $this->assertInstanceOf('DateTime', $this->eventId->occurrenceDate());
    }

    public function testTimestamp()
    {
        $this->assertInternalType('float', $this->eventId->timestamp());
    }

    public function testToString()
    {
        $match = '#[a-z0-9_\.\-\\]+_\d{10}\.\d{6}_[a-f0-9]{8}#i';
        $this->assertRegExp($match, (string) $this->eventId);
    }

    public function testFromStringReturnsEventId()
    {
        $this->assertEquals($this->eventId, EventId::fromString((string) $this->eventId));
    }

    public function testFromStringThrowsException()
    {
        $this->expectException(
            'texdc\momento\exception\EventException',
            'Invalid id format [test_fail]'
        );
        EventId::fromString('test_fail');
    }

    public function testJsonSerialize()
    {
        $this->assertInternalType('string', json_encode($this->eventId));
    }

    public function testSerialize()
    {
        $this->assertInternalType('string', serialize($this->eventId));
    }

    public function testUnserialize()
    {
        $data = serialize($this->eventId);
        $this->assertEquals($this->eventId, unserialize($data));
    }

    public function testOccurredBeforeReturnsBool()
    {
        $id = new EventId(__CLASS__);
        $this->assertTrue($this->eventId->occurredBefore($id));
    }

    public function testOccurredAfterReturnsBool()
    {
        $id = new EventId(__CLASS__);
        $this->assertFalse($this->eventId->occurredAfter($id));
    }
}

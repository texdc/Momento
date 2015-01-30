<?php
/**
 * EventIdTest.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest;

use PHPUnit_Framework_TestCase as TestCase;
use Momento\EventId;

class EventIdTest extends TestCase
{
    const EVENT_TYPE = __CLASS__;

    /**
     * @var EventId
     */
    private $eventId;

    protected function setUp()
    {
        $this->eventId = new EventId(static::EVENT_TYPE);
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
        $this->assertSame(static::EVENT_TYPE, $this->eventId->eventType());
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

    public function testFromStringThrowsException()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Invalid format [test_fail]'
        );
        EventId::fromString('test_fail');
    }

    public function testEquals()
    {
        $id = (string) $this->eventId;
        $this->assertTrue($this->eventId->equals(EventId::fromString($id)));
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
        $this->assertTrue($this->eventId->equals(unserialize($data)));
    }
}

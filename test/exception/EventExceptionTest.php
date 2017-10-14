<?php
/**
 * EventExceptionTest.php
 *
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 2016 George D. Cooksey, III
 */

namespace texdc\momento\test;

use PHPUnit\Framework\TestCase;
use texdc\momento\exception\EventException;

class EventExceptionTest extends TestCase
{
    public function testInstanceOfDomainException()
    {
        $this->assertInstanceOf('DomainException', new EventException());
    }

    public function testInvalidType()
    {
        $subject = EventException::invalidType('foo');
        $this->assertEquals('Invalid event type [foo]', $subject->getMessage());
        $this->assertEquals(EventException::CODE_INVALID_TYPE, $subject->getCode());
    }

    public function testInvalidId()
    {
        $subject = EventException::invalidId('foo');
        $this->assertEquals('Invalid id format [foo]', $subject->getMessage());
        $this->assertEquals(EventException::CODE_INVALID_ID, $subject->getCode());
    }
}

<?php
/**
 * AbstractEventTest.php
 *
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 2015 George D. Cooksey, III
 */

namespace texdc\momento\test;

use PHPUnit_Framework_TestCase as TestCase;
use texdc\momento\exception\EventException;

class EventExceptionTest extends TestCase
{
    public function testInstanceOfDomainException()
    {
        $this->assertInstanceOf('DomainException', new EventException());
    }

    public function testInvalidTypeMessage()
    {
        $subject = EventException::invalidType('foo');
        $this->assertEquals('Invalid event type [foo]', $subject->getMessage());
    }
}

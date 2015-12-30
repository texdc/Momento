<?php
/**
 * HandlerExceptionTest.php
 *
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 2015 George D. Cooksey, III
 */

namespace texdc\momento\test;

use PHPUnit_Framework_TestCase as TestCase;
use texdc\momento\exception\HandlerException;

class HandlerExceptionTest extends TestCase
{
    public function testInstanceOfDomainException()
    {
        $this->assertInstanceOf('DomainException', new HandlerException());
    }

    public function testDuplicate()
    {
        $handler = function () {};
        $subject = HandlerException::duplicate($handler);
        $this->assertEquals(
            sprintf('Duplicate handler [%s]', get_class($handler)),
            $subject->getMessage()
        );
        $this->assertEquals(HandlerException::CODE_DUPLICATE, $subject->getCode());
    }
}

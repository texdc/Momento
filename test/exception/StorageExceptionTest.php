<?php
/**
 * StorageExceptionTest.php
 *
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 2015 George D. Cooksey, III
 */

namespace texdc\momento\test;

use PHPUnit_Framework_TestCase as TestCase;
use texdc\momento\exception\StorageException;

class StorageExceptionTest extends TestCase
{
    public function testInstanceOfDomainException()
    {
        $this->assertInstanceOf('DomainException', new StorageException());
    }

    public function testDuplicateEvent()
    {
        $subject = StorageException::duplicateEvent('foo');
        $this->assertEquals('Duplicate event [foo]', $subject->getMessage());
        $this->assertEquals(StorageException::CODE_DUPLICATE_EVENT, $subject->getCode());
    }

    public function testUnknownEventId()
    {
        $subject = StorageException::unknownEventId('foo');
        $this->assertEquals('Unrecognized event id [foo]', $subject->getMessage());
        $this->assertEquals(StorageException::CODE_UNKNOWN_EVENT_ID, $subject->getCode());
    }
}

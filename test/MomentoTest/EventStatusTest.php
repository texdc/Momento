<?php
/**
 * EventStatusTest.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest;

use PHPUnit_Framework_TestCase as TestCase;
use Momento\EventStatus;

class EventStatusTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Momento\EventStatus'));
    }

    public function testSanitizeTrimsAndLowers()
    {
        $this->assertInstanceOf('Momento\EventStatus', new EventStatus(' FAILED '));
    }

    public function testValidateThrowsException()
    {
        $this->setExpectedException(
            'Momento\Exception\InvalidEventStatusException',
            'Invalid event status [foo]'
        );
        $subject = new EventStatus('foo');
    }

    public function testCallStaticReturnsInstance()
    {
        $this->assertInstanceOf('Momento\EventStatus', EventStatus::Success());
    }

    public function testIsSuccessReturnsBool()
    {
        $this->assertFalse(EventStatus::Failed()->isSuccess());
    }

    public function testIsStoppedReturnsBool()
    {
        $this->assertFalse(EventStatus::Failed()->isStopped());
    }

    public function testIsFailedReturnsBool()
    {
        $this->assertFalse(EventStatus::Stopped()->isFailed());
    }

    public function testStringConversion()
    {
        $this->assertEquals(EventStatus::STATUS_STOPPED, (string) EventStatus::Stopped());
    }
}

<?php
/**
 * EventResultTraitTest.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest;

use MomentoTest\TestAsset\TestResult;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers \Momento\EventResultTrait
 */
class EventResultTraitTest extends TestCase
{
    public function testTraitExists()
    {
        $this->assertTrue(trait_exists('Momento\EventResultTrait'));
    }

    public function testEventReturnsEvent()
    {
        $event = $this->getMockForAbstractClass('Momento\Event');
        $subject = new TestResult($event);
        $this->assertSame($event, $subject->event());
    }

    public function testIsFinalReturnsBool()
    {
        $event = $this->getMockForAbstractClass('Momento\Event');
        $subject = new TestResult($event, true);
        $this->assertTrue($subject->isFinal());
    }
}

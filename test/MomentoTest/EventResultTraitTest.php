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

    public function testIsFinalReturnsBool()
    {
        $subject = new TestResult(true);
        $this->assertTrue($subject->isFinal());
    }

    public function testIsSuccessReturnsBool()
    {
        $subject = new TestResult();
        $this->assertTrue($subject->isSuccess());
    }

    public function testGetErrorsReturnsArray()
    {
        $subject = new TestResult();
        $this->assertInternalType('array', $subject->getErrors());
    }

    public function testMagicGetThrowsException()
    {
        $this->setExpectedException(
            'Momento\Exception\InvalidPropertyException',
            'foo is not a valid property'
        );
        $subject = new TestResult();
        $subject->foo;
    }

    public function testMagicGetUsesGetter()
    {
        $subject = new TestResult();
        $this->assertInternalType('array', $subject->errors);
    }

    public function testMagicGetUsesProperty()
    {
        $subject = new TestResult();
        $this->assertInternalType('boolean', $subject->final);
    }

    public function testMagicSetThrowsException()
    {
        $this->setExpectedException(
            'Momento\Exception\ImmutableException',
            'MomentoTest\TestAsset\TestResult is immutable'
        );
        $subject = new TestResult();
        $subject->final = false;
    }
}

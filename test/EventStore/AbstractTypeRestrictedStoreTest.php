<?php
/**
 * AbstractTypeRestrictedStoreTest.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest\EventStore;

use Momento\EventId;
use MomentoTest\TestAsset\TypeRestrictedStoreAsset;
use PHPUnit_Framework_TestCase as TestCase;

class AbstractTypeRestrictedStoreTest extends TestCase
{
    const CLASSNAME = 'Momento\EventStore\AbstractTypeRestrictedStore';

    public function testClassExists()
    {
        $this->assertTrue(class_exists(static::CLASSNAME));
    }

    public function testClassImplementsEventStoreInterface()
    {
        $subject = $this->getMockForAbstractClass(static::CLASSNAME, [__CLASS__]);
        $this->assertInstanceOf('Momento\EventStoreInterface', $subject);
    }

    public function testClassImplementsLimitsEventTypesInterface()
    {
        $subject = $this->getMockForAbstractClass(static::CLASSNAME, [__CLASS__]);
        $this->assertInstanceOf('Momento\LimitsEventTypesInterface', $subject);
    }

    public function testAcceptsEventTypeReturnsBool()
    {
        $subject = new TypeRestrictedStoreAsset(__CLASS__);
        $this->assertFalse($subject->acceptsEventType('foo'));
    }

    public function testGuardValidTypeThrowsInvalidEventTypeException()
    {
        $subject = new TypeRestrictedStoreAsset(__CLASS__);
        $subject->findAllSince(new EventId(__CLASS__));
        $this->setExpectedException('Momento\Exception\InvalidEventTypeException');
        $subject->findAllSince(new EventId('foo'));
    }
}

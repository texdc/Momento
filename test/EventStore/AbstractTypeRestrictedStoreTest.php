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

    public function testClassImplementsTypeRestricedStoreInterface()
    {
        $subject = $this->getMockForAbstractClass(static::CLASSNAME, [__CLASS__]);
        $this->assertInstanceOf('Momento\EventStore\TypeRestrictedStoreInterface', $subject);
    }

    public function testIsValidEventTypeReturnsBool()
    {
        $subject = new TypeRestrictedStoreAsset(__CLASS__);
        $this->assertFalse($subject->isValidEventType('foo'));
    }

    public function testGuardValidTypeThrowsInvalidEventTypeException()
    {
        $subject = new TypeRestrictedStoreAsset(__CLASS__);
        $subject->allSince(new EventId(__CLASS__));
        $this->setExpectedException('Momento\Exception\InvalidEventTypeException');
        $subject->allSince(new EventId('foo'));
    }
}

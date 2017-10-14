<?php
/**
 * AbstractTypeRestrictedStoreTest.php
 *
 * @copyright 2016 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\test\storage;

use texdc\momento\EventId;
use texdc\momento\test\asset\TypeRestrictedStore;
use PHPUnit\Framework\TestCase;

class AbstractTypeRestrictedStoreTest extends TestCase
{
    const CLASSNAME = 'texdc\momento\storage\AbstractTypeRestrictedStore';

    public function testClassExists()
    {
        $this->assertTrue(class_exists(static::CLASSNAME));
    }

    public function testClassImplementsTypeRestricedStoreInterface()
    {
        $subject = $this->getMockForAbstractClass(static::CLASSNAME, [__CLASS__]);
        $this->assertInstanceOf('texdc\momento\storage\TypeRestrictedStoreInterface', $subject);
    }

    public function testIsValidEventTypeReturnsBool()
    {
        $subject = new TypeRestrictedStore(__CLASS__);
        $this->assertFalse($subject->isValidEventType('foo'));
    }

    public function testGuardValidTypeThrowsEventException()
    {
        $subject = new TypeRestrictedStore(__CLASS__);
        $subject->findAllSince(new EventId(__CLASS__));
        $this->expectException('texdc\momento\exception\EventException');
        $subject->findAllSince(new EventId('foo'));
    }
}

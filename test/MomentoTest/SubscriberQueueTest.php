<?php
/**
 * SubscriberQueueTest.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest;

use PHPUnit_Framework_TestCase as TestCase;
use Momento\SubscriberQueue;

class SubscriberQueueTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Momento\SubscriberQueue'));
    }

    public function testClassImplementsCountable()
    {
        $this->assertInstanceOf('Countable', new SubscriberQueue);
    }

    public function testClassImplementsIteratorAggregate()
    {
        $this->assertInstanceOf('IteratorAggregate', new SubscriberQueue);
    }

    public function testToArrayReturnsArray()
    {
        $subject = new SubscriberQueue;
        $this->assertInternalType('array', $subject->toArray());
    }

    public function testInsertRejectsDuplicates()
    {
        $subject = new SubscriberQueue;
        $handler = $this->getMockForAbstractClass('Momento\EventHandler');
        $subject->insert($handler, 1);
        $this->setExpectedException('InvalidArgumentException', 'Duplicate handler');
        $subject->insert($handler, 2);
    }

    public function testToArrayContainsInsertedSubscribers()
    {
        $handler = $this->getMockForAbstractClass('Momento\EventHandler');
        $subject = new SubscriberQueue;
        $subject->insert($handler, 1);
        $this->assertContains($handler, $subject->toArray());
    }

    public function testRemoveResetsQueue()
    {
        $subject  = new SubscriberQueue;
        $handler1 = $this->getMockForAbstractClass('Momento\EventHandler');
        $subject->insert($handler1, 1);
        $handler2 = $this->getMockForAbstractClass('Momento\EventHandler');
        $subject->insert($handler2, 1);
        $subject->remove($handler1);
        $this->assertEquals(1, $subject->count());
    }

    public function testTop()
    {
        $subject = new SubscriberQueue;
        $handler = $this->getMockForAbstractClass('Momento\EventHandler');
        $subject->insert($handler, 1);
        $this->assertSame($handler, $subject->top());
    }
}

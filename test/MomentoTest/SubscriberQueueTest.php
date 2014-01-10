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
        $subscriber = $this->getMockForAbstractClass('Momento\DomainEventSubscriber');
        $subject->insert($subscriber, 1);
        $this->setExpectedException('InvalidArgumentException', 'Duplicate subscriber');
        $subject->insert($subscriber, 2);
    }

    public function testToArrayContainsInsertedSubscribers()
    {
        $subscriber = $this->getMockForAbstractClass('Momento\DomainEventSubscriber');
        $subject = new SubscriberQueue;
        $subject->insert($subscriber, 1);
        $this->assertContains($subscriber, $subject->toArray());
    }

    public function testRemoveResetsQueue()
    {
        $subject = new SubscriberQueue;
        $subscriber1 = $this->getMockForAbstractClass('Momento\DomainEventSubscriber');
        $subject->insert($subscriber1, 1);
        $subscriber2 = $this->getMockForAbstractClass('Momento\DomainEventSubscriber');
        $subject->insert($subscriber2, 1);
        $subject->remove($subscriber1);
        $this->assertEquals(1, $subject->count());
    }

    public function testTop()
    {
        $subject = new SubscriberQueue;
        $subscriber = $this->getMockForAbstractClass('Momento\DomainEventSubscriber');
        $subject->insert($subscriber, 1);
        $this->assertSame($subscriber, $subject->top());
    }
}

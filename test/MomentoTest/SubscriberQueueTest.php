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

    public function testClassExtendsSplPriorityQueue()
    {
        $this->assertInstanceOf('SplPriorityQueue', new SubscriberQueue);
    }

    public function testToArrayReturnsArray()
    {
        $subject = new SubscriberQueue;
        $this->assertInternalType('array', $subject->toArray());
    }

    public function testInsertOnlyAcceptsSubscribers()
    {
        $subject = new SubscriberQueue;
        $this->setExpectedException(
            'InvalidArgumentException',
            'Inserted elements must be an instance of Momento\DomainEventSubscriber, [string] provided'
        );
        $subject->insert('foo', 1);
    }

    public function testToArrayContainsInsertedSubscribers()
    {
        $subscriber = $this->getMockForAbstractClass('Momento\DomainEventSubscriber');
        $subject = new SubscriberQueue;
        $subject->insert($subscriber, 1);
        $this->assertContains($subscriber, $subject->toArray());
    }
}

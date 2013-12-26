<?php
/**
 * DomainEventPublisherTest.php
 *
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 2013 George D. Cooksey, III
 */

namespace MomentoTest;

use PHPUnit_Framework_TestCase as TestCase;
use Momento\DomainEventPublisher;

class DomainEventPublisherTest extends TestCase
{

    public function testClassExists()
    {
        $this->assertTrue(class_exists('Momento\DomainEventPublisher'));
    }

    public function testSubscribersIsArray()
    {
        $subject = new DomainEventPublisher;
        $this->assertInternalType('array', $subject->subscribers());
    }

    public function testRegisterRegistersSubscriber()
    {
        $subscriber = $this->getMockForAbstractClass('Momento\DomainEventSubscriber');
        $subject = new DomainEventPublisher;
        $subject->register($subscriber);
        $this->assertContains($subscriber, $subject->subscribers());
    }

    public function testUnregisterRemovesSubscriber()
    {
        $subscriber = $this->getMockForAbstractClass('Momento\DomainEventSubscriber');
        $subject = new DomainEventPublisher;
        $subject->register($subscriber);
        $subject->unregister($subscriber);
        $this->assertNotContains($subscriber, $subject->subscribers());
    }

    public function testUnregisterIgnoresUnregisteredSubscriber()
    {
        $subscriber = $this->getMockForAbstractClass('Momento\DomainEventSubscriber');
        $subject = new DomainEventPublisher;
        $subject->unregister($subscriber);
        $this->assertNotContains($subscriber, $subject->subscribers());
    }

    public function testPublishDispatchesEventToItsSubscribers()
    {
        $subscriber1 = $this->getMockForAbstractClass('Momento\DomainEventSubscriber');
        $subscriber1
            ->expects($this->once())
            ->method('subscribedEventType')
            ->will($this->returnValue('foo'));
        $subscriber1
            ->expects($this->never())
            ->method('handle');

        $event = $this->getMockForAbstractClass('Momento\DomainEvent');

        $subscriber2 = $this->getMockForAbstractClass('Momento\DomainEventSubscriber');
        $subscriber2
            ->expects($this->once())
            ->method('subscribedEventType')
            ->will($this->returnValue(get_class($event)));
        $subscriber2
            ->expects($this->once())
            ->method('handle')
            ->with($event);

        $subject = new DomainEventPublisher([$subscriber1, $subscriber2]);
        $subject->publish($event);
    }

    public function testEqualsComparesSubscribers()
    {
        $subscriber = $this->getMockForAbstractClass('Momento\DomainEventSubscriber');
        $subject = new DomainEventPublisher([$subscriber]);
        $this->assertFalse($subject->equals(new DomainEventPublisher));
    }
}

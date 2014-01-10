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
        $subscriber = $this->buildSubscriber();
        $subject = new DomainEventPublisher;
        $subject->register($subscriber);
        $this->assertContains($subscriber, $subject->subscribers());
    }

    public function testUnregisterRemovesSubscriber()
    {
        $subscriber = $this->buildSubscriber();
        $subject = new DomainEventPublisher;
        $subject->register($subscriber);
        $subject->unregister($subscriber);
        $this->assertNotContains($subscriber, $subject->subscribers());
    }

    public function testUnregisterIgnoresUnregisteredSubscriber()
    {
        $subscriber = $this->buildSubscriber();
        $subject = new DomainEventPublisher;
        $subject->unregister($subscriber);
        $this->assertNotContains($subscriber, $subject->subscribers());
    }

    public function testPublishDispatchesEventToItsSubscribers()
    {
        $event = $this->getMockForAbstractClass('Momento\DomainEvent');
        $event
            ->expects($this->once())
            ->method('eventType')
            ->will($this->returnValue('test'));

        $subscriber1 = $this->buildSubscriber();
        $subscriber1
            ->expects($this->once())
            ->method('handlesEventType')
            ->with('test')
            ->will($this->returnValue(false));
        $subscriber1
            ->expects($this->never())
            ->method('handle');

        $subscriber2 = $this->buildSubscriber();
        $subscriber2
            ->expects($this->once())
            ->method('handlesEventType')
            ->with('test')
            ->will($this->returnValue(true));
        $subscriber2
            ->expects($this->once())
            ->method('handle')
            ->with($event);

        $subject = new DomainEventPublisher([$subscriber1, $subscriber2]);
        $subject->publish($event);
    }

    private function buildSubscriber(array $handledEventTypes = ['test'])
    {
        $subscriber = $this->getMockForAbstractClass('Momento\DomainEventSubscriber');
        $subscriber
            ->expects($this->any())
            ->method('listHandledEventTypes')
            ->will($this->returnValue($handledEventTypes));
        return $subscriber;
    }
}

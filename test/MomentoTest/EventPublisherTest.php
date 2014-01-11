<?php
/**
 * EventPublisherTest.php
 *
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 2013 George D. Cooksey, III
 */

namespace MomentoTest;

use PHPUnit_Framework_TestCase as TestCase;
use Momento\EventPublisher;

class EventPublisherTest extends TestCase
{

    public function testClassExists()
    {
        $this->assertTrue(class_exists('Momento\EventPublisher'));
    }

    public function testSubscribersIsArray()
    {
        $subject = new EventPublisher;
        $this->assertInternalType('array', $subject->subscribers());
    }

    public function testRegisterRegistersSubscriber()
    {
        $subscriber = $this->buildSubscriber();
        $subject = new EventPublisher;
        $subject->register($subscriber);
        $this->assertContains($subscriber, $subject->subscribers('test'));
    }

    public function testConstructorWithSubscriberArray()
    {
        $subscriber1 = $this->buildSubscriber(['foo']);
        $subscriber2 = $this->buildSubscriber();
        $subject     = new EventPublisher([
            ['subscriber' => $subscriber1, 'priority' => 1],
            ['subscriber' => $subscriber2, 'priority' => 5],
        ]);
        $this->assertArrayHasKey('foo', $subject->subscribers());
        $this->assertArrayHasKey('test', $subject->subscribers());
    }

    public function testUnregisterRemovesSubscriber()
    {
        $subscriber = $this->buildSubscriber();
        $subject = new EventPublisher;
        $subject->register($subscriber);
        $subject->unregister($subscriber);
        $this->assertNotContains($subscriber, $subject->subscribers('test'));
    }

    public function testPublishDispatchesEventToItsSubscribers()
    {
        $event = $this->getMockForAbstractClass('Momento\Event');
        $event
            ->expects($this->once())
            ->method('eventType')
            ->will($this->returnValue('test'));

        $subscriber1 = $this->buildSubscriber(['foo']);
        $subscriber1
            ->expects($this->never())
            ->method('handle');

        $subscriber2 = $this->buildSubscriber();
        $subscriber2
            ->expects($this->once())
            ->method('handle')
            ->with($event);

        $subject = new EventPublisher([$subscriber1, $subscriber2]);
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

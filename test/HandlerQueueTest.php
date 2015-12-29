<?php
/**
 * HandlerQueueTest.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\test;

use PHPUnit_Framework_TestCase as TestCase;
use texdc\momento\HandlerQueue;

class HandlerQueueTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('texdc\momento\HandlerQueue'));
    }

    public function testClassImplementsCountable()
    {
        $this->assertInstanceOf('Countable', new HandlerQueue);
    }

    public function testClassImplementsIteratorAggregate()
    {
        $this->assertInstanceOf('IteratorAggregate', new HandlerQueue);
    }

    public function testToArrayReturnsArray()
    {
        $subject = new HandlerQueue;
        $this->assertInternalType('array', $subject->toArray());
    }

    public function testInsertRejectsDuplicates()
    {
        $subject = new HandlerQueue;
        $handler = $this->getMockForAbstractClass('texdc\momento\EventHandlerInterface');
        $subject->insert($handler);
        $this->setExpectedException('texdc\momento\exception\HandlerException');
        $subject->insert($handler, 2);
    }

    public function testToArrayContainsInsertedHandlers()
    {
        $handler = $this->getMockForAbstractClass('texdc\momento\EventHandlerInterface');
        $subject = new HandlerQueue;
        $subject->insert($handler);
        $this->assertContains($handler, $subject->toArray());
    }

    public function testRemoveResetsQueue()
    {
        $subject  = new HandlerQueue;
        $handler1 = $this->getMockForAbstractClass('texdc\momento\EventHandlerInterface');
        $subject->insert($handler1);
        $handler2 = $this->getMockForAbstractClass('texdc\momento\EventHandlerInterface');
        $subject->insert($handler2);
        $subject->remove($handler1);
        $this->assertEquals(1, $subject->count());
    }

    public function testTop()
    {
        $subject = new HandlerQueue;
        $handler1 = $this->getMockForAbstractClass('texdc\momento\EventHandlerInterface');
        $subject->insert($handler1);
        $handler2 = $this->getMockForAbstractClass('texdc\momento\EventHandlerInterface');
        $subject->insert($handler2, 2);
        $this->assertSame($handler2, $subject->top());
    }

    public function testIsEmpty()
    {
        $subject = new HandlerQueue;
        $this->assertTrue($subject->isEmpty());
        $handler = $this->getMockForAbstractClass('texdc\momento\EventHandlerInterface');
        $subject->insert($handler);
        $this->assertFalse($subject->isEmpty());
    }
}

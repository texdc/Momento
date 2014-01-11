<?php
/**
 * HandlerQueueTest.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest;

use PHPUnit_Framework_TestCase as TestCase;
use Momento\HandlerQueue;

class HandlerQueueTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Momento\HandlerQueue'));
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
        $handler = $this->getMockForAbstractClass('Momento\EventHandler');
        $subject->insert($handler, 1);
        $this->setExpectedException(
            'Momento\Exception\DuplicateHandlerException',
            sprintf('Duplicate handler [%s]', get_class($handler))
        );
        $subject->insert($handler, 2);
    }

    public function testToArrayContainsInsertedHandlers()
    {
        $handler = $this->getMockForAbstractClass('Momento\EventHandler');
        $subject = new HandlerQueue;
        $subject->insert($handler, 1);
        $this->assertContains($handler, $subject->toArray());
    }

    public function testRemoveResetsQueue()
    {
        $subject  = new HandlerQueue;
        $handler1 = $this->getMockForAbstractClass('Momento\EventHandler');
        $subject->insert($handler1, 1);
        $handler2 = $this->getMockForAbstractClass('Momento\EventHandler');
        $subject->insert($handler2, 1);
        $subject->remove($handler1);
        $this->assertEquals(1, $subject->count());
    }

    public function testTop()
    {
        $subject = new HandlerQueue;
        $handler = $this->getMockForAbstractClass('Momento\EventHandler');
        $subject->insert($handler, 1);
        $this->assertSame($handler, $subject->top());
    }
}

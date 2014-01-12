<?php
/**
 * TestResult.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest\TestAsset;

use Momento\Event;
use Momento\EventResult;

class TestResult implements EventResult
{
    use \Momento\EventResultTrait;

    public function __construct(Event $event, $final = false)
    {
        $this->event = $event;
        $this->final = $final;
    }
}

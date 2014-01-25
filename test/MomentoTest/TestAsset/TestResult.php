<?php
/**
 * TestResult.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest\TestAsset;

use Momento\EventResult;
use Momento\EventResultTrait;

class TestResult implements EventResult
{
    use EventResultTrait;

    public function __construct($asFinal = false, array $withErrors = [])
    {
        $this->setFinal($asFinal);
        $this->setErrors($withErrors);
    }
}

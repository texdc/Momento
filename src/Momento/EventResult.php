<?php
/**
 * EventResult.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * EventResults are value objects that may contain a variety of data.  The minimum
 * should be a $final flag to denote the halting of further processing, a $success
 * flag to denote successful processing, and a potential list of processing errors.
 *
 * @package Momento
 */
interface EventResult
{
    /**
     * Was the processing successful?
     *
     * @return bool
     */
    public function isSuccess();

    /**
     * Should event processing be halted?
     *
     * @return bool
     */
    public function isFinal();

    /**
     * Get the processing errors
     *
     * @return string[]
     */
    public function getErrors();
}

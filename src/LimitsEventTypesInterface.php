<?php
/**
 * LimitsEventTypesInterface.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Provides verification of acceptable event types for classes that restrict them.
 *
 * @author George D. Cooksey, III
 */
interface LimitsEventTypesInterface
{
    /**
     * Determine if an event type is acceptable
     *
     * @param  string $anEventType
     * @return bool
     */
    public function acceptsEventType($anEventType);
}

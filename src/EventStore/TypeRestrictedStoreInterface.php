<?php
/**
 * TypeRestrictedStoreInterface.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento\EventStore;

use Momento\EventStoreInterface;

/**
 * Allows stores to restict event ids and instances by their event type.
 *
 * @author George D. Cooksey, III
 */
interface TypeRestrictedStoreInterface extends EventStoreInterface
{
    /**
     * @param  string $anEventType
     * @return bool
     */
    public function isValidEventType($anEventType);
}

<?php
/**
 * AbstractTypeRestrictedStore.php
 *
 * @copyright 2017 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\storage;

use texdc\momento\exception\EventException;

/**
 * Allows stores to restrict event ids and instances by their event type
 *
 * @author George D. Cooksey, III
 */
abstract class AbstractTypeRestrictedStore implements TypeRestrictedStoreInterface
{
    /**
     * @var string
     */
    protected $validEventType;

    /**
     * @param string $anEventType the valid event type
     */
    public function __construct(string $anEventType)
    {
        $this->validEventType = $anEventType;
    }

    /**
     * @param  string $anEventType
     * @return bool
     */
    public function isValidEventType(string $anEventType) : bool
    {
        return $this->validEventType == $anEventType;
    }

    /**
     * @param  string $anEventType
     * @throws InvalidEventTypeException
     */
    protected function guardEventType(string $anEventType)
    {
        if (!$this->isValidEventType($anEventType)) {
            throw EventException::invalidType($anEventType);
        }
    }
}

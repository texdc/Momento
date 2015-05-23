<?php
/**
 * AbstractTypeRestrictedStore.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento\EventStore;

use Momento\Exception\InvalidEventTypeException;
use Momento\EventStoreInterface;
use Momento\LimitsEventTypesInterface;

/**
 * Allows stores to restrict event ids and instances by their event type
 *
 * @author George D. Cooksey, III
 */
abstract class AbstractTypeRestrictedStore implements EventStoreInterface, LimitsEventTypesInterface
{
    /**
     * @var string
     */
    protected $validEventType;

    /**
     * @param string $anEventType the valid event type
     */
    public function __construct($anEventType)
    {
        $this->validEventType = (string) $anEventType;
    }

    /**
     * (non-PHPdoc)
     * @see \Momento\LimitsEventTypesInterface::acceptsEventType()
     */
    public function acceptsEventType($anEventType)
    {
        return $this->validEventType == (string) $anEventType;
    }

    /**
     * @param  string $anEventType
     * @throws InvalidEventTypeException
     */
    protected function guardEventType($anEventType)
    {
        if (!$this->acceptsEventType($anEventType)) {
            throw new InvalidEventTypeException("Unrecognized event type [$anEventType]");
        }
    }
}

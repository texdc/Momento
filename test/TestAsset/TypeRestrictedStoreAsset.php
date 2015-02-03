<?php
/**
 * TypeRestrictedStoreAsset.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace MomentoTest\TestAsset;

use Momento\EventId;
use Momento\EventInterface;
use Momento\EventStore\AbstractTypeRestrictedStore;

class TypeRestrictedStoreAsset extends AbstractTypeRestrictedStore
{
    public function findAllBetween(EventId $aLowEventId, EventId $aHighEventId)
    {
        // ...
    }

    public function findAllSince(EventId $anEventId)
    {
        $this->guardEventType($anEventId->eventType());
    }

    public function findById(EventId $anEventId)
    {
        // ...
    }

    public function append(EventInterface $anEvent)
    {
        // ...
    }

    public function count()
    {
        // ...
    }
}

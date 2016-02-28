<?php
/**
 * TypeRestrictedStore.php
 *
 * @copyright 2016 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\test\asset;

use texdc\momento\EventId;
use texdc\momento\EventInterface;
use texdc\momento\storage\AbstractTypeRestrictedStore;

class TypeRestrictedStore extends AbstractTypeRestrictedStore
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

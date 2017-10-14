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
    private $events = [];

    public function findAllBetween(EventId $aLowEventId, EventId $aHighEventId) : array
    {
        $this->guardEventType($aLowEventId->eventType());
        $this->guardEventType($aHighEventId->eventType());
        return $this->events;
    }

    public function findAllSince(EventId $anEventId) : array
    {
        $this->guardEventType($anEventId->eventType());
        return $this->events;
    }

    public function findById(EventId $anEventId) : EventInterface
    {
        return null;
    }

    public function record(EventInterface $anEvent) : void
    {
        // ...
    }

    public function count() : int
    {
        return count($this->events);
    }
}

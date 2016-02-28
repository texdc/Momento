<?php
/**
 * EventId.php
 *
 * @copyright 2016 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento;

use DateTime;
use InvalidArgumentException;
use Serializable;
use JsonSerializable;
use texdc\momento\exception\EventException;

/**
 * Provides a rich identity for events that encapsulates the event type and timestamp
 * with a short hash for uniqueness.
 *
 * @author George D. Cooksey, III
 */
class EventId implements JsonSerializable, Serializable
{
    /**
     * @var string
     */
    protected $hash;

    /**
     * @var float
     */
    protected $time;

    /**
     * @var string
     */
    protected $type;

    /**
     * Constructor
     *
     * @param string $eventType the event type
     */
    public function __construct($eventType)
    {
        $this->time = microtime(true);
        $this->hash = hash('crc32', mt_rand(0, $this->time));
        $this->type = trim($eventType);
    }

    /**
     * Parse a string into an id
     *
     * @param  string $eventId the string to parse
     * @return EventId
     * @throws InvalidArgumentException when the string format is invalid
     */
    public static function fromString($eventId)
    {
        $parts = explode('_', $eventId);
        if (count($parts) != 3) {
            throw EventException::invalidId($eventId);
        }

        $id       = new static($parts[0]);
        $id->time = (float) $parts[1];
        $id->hash = (string) $parts[2];

        return $id;
    }

    /**
     * @param  self $anEventId
     * @return bool
     */
    public function occurredBefore(self $anEventId)
    {
        return $this->time < $anEventId->time;
    }

    /**
     * @param  self $anEventId
     * @return bool
     */
    public function occurredAfter(self $anEventId)
    {
        return $this->time > $anEventId->time;
    }

    /**
     * @return string
     */
    public function eventType()
    {
        return $this->type;
    }

    /**
     * @return DateTime
     */
    public function occurrenceDate()
    {
        return DateTime::createFromFormat('U.u', $this->time);
    }

    /**
     * @return float
     */
    public function timestamp()
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return (string) $this;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->jsonSerialize());
    }

    /**
     * @param  string $serialized
     * @return EventId
     */
    public function unserialize($serialized)
    {
        $id = static::fromString(unserialize($serialized));
        $this->hash = $id->hash;
        $this->time = $id->time;
        $this->type = $id->type;
    }

    /**
     * Convert to a formatted string
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s_%f_%s", $this->type, $this->time, $this->hash);
    }
}

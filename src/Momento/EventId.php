<?php
/**
 * EventId.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

use DateTime;
use InvalidArgumentException;

/**
 * Provides a rich identity for events that encapsulates the event type and timestamp
 * with a short hash for uniqueness.
 *
 * @author George D. Cooksey, III
 */
class EventId
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
            throw new InvalidArgumentException("Invalid format [$eventId]");
        }

        $id       = new static($parts[0]);
        $id->time = (float) $parts[1];
        $id->hash = (string) $parts[2];

        return $id;
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
     * Compare another id for equality
     *
     * @param  EventId $other the other id to compare
     * @return bool
     */
    public function equals(self $other)
    {
        return (
            $this->type    == $other->type
            && $this->time == $other->time
            && $this->hash == $other->hash
        );
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

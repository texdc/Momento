<?php
/**
* EventStatus.php
*
* @copyright 2014 George D. Cooksey, III
* @license http://www.opensource.org/licenses/mit-license.html MIT License
*/

namespace Momento;

/**
 * Event lifecycle status: success, stopped, or failed
 *
 * @package Momento
 */
final class EventStatus
{
    /**#@+
     * @var string
     */
    const STATUS_SUCCESS = 'success';
    const STATUS_STOPPED = 'stopped';
    const STATUS_FAILED  = 'failed';
    /**#@- */

    /**
     * @var string[]
     */
    private static $validStatuses = [
        self::STATUS_SUCCESS,
        self::STATUS_STOPPED,
        self::STATUS_FAILED
    ];

    /**
     * @var string
     */
    private $status = self::STATUS_SUCCESS;


    /**
     * Constructor
     *
     * @param string $aStatus the event status
     */
    public function __construct($aStatus = self::STATUS_SUCCESS)
    {
        $this->status = $this->sanitizeAndValidate($aStatus);
    }

    /**
     * Allow static initialization
     * <code>
     * $status = EventStatus::Stopped();
     * </code>
     *
     * @param  string $aStatus   the event status
     * @param  array  $arguments ignored
     * @return self
     */
    public static function __callStatic($aStatus, $arguments = [])
    {
        return new static($aStatus);
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return ($this->status == static::STATUS_SUCCESS);
    }

    /**
     * @return bool
     */
    public function isStopped()
    {
        return ($this->status == static::STATUS_STOPPED);
    }

    /**
     * @return bool
     */
    public function isFailed()
    {
        return ($this->status == static::STATUS_FAILED);
    }

    /**
     * Convert to a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->status;
    }

    /**
     * @param  string $aStatus the status
     * @return string
     */
    private function sanitize($aStatus)
    {
        return strtolower(trim($aStatus));
    }

    /**
     * @param  string $aStatus the status
     * @return void
     * @throws DomainException
     */
    private function validate($aStatus)
    {
        if (!in_array($aStatus, static::$validStatuses)) {
            throw new Exception\InvalidEventStatusException(
                "Invalid event status [$aStatus]"
            );
        }
    }

    /**
     * @param  string $aStatus the status
     * @return string
     */
    private function sanitizeAndValidate($aStatus)
    {
        $sanitized = $this->sanitize($aStatus);
        $this->validate($sanitized);
        return $sanitized;
    }
}

<?php
/**
* EventStatus.php
*
* @copyright 2014 George D. Cooksey, III
* @license http://www.opensource.org/licenses/mit-license.html MIT License
*/

namespace Momento;

use DomainException;

/**
 * Event lifecycle status: success, stopped, or failed
 * 
 * @package Momento
 */
class EventStatus
{
    /**#@+
     * @var string
     */
    const SUCCESS = 'success';
    const STOPPED = 'stopped';
    const FAILED  = 'failed';
    /**#@- */
    
    /**
     * @var string[]
     */
    private static $validStatuses = [
        self::SUCCESS,
        self::STOPPED,
        self::FAILED
    ];
    
    /**
     * @var string
     */
    private $status = self::SUCCESS;
    
    
    /**
     * Constructor
     * 
     * @param string $aStatus the event status
     */
    public function __construct($aStatus = self::SUCCESS)
    {
        $this->status = $this->sanitizeAndValidate($aStatus);
    }
    
    /**
     * Allow static initialization
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
        return ($this->status == static::SUCCESS);
    }
    
    /**
     * @return bool
     */
    public function isStopped()
    {
        return ($this->status == static::STOPPED);
    }
    
    /**
     * @return bool
     */
    public function isFailed()
    {
        return ($this->status == static::FAILED);
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
            throw new DomainException("Invalid event status [$aStatus]");
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

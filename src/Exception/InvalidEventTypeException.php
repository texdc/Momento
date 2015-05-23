<?php
/**
 * InvalidEventTypeException.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento\Exception;

use Exception;
use InvalidArgumentException;

/**
 * Announces an invalid event type
 *
 * @see    \Momento\EventPublisher::guardValidEventType()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class InvalidEventTypeException extends InvalidArgumentException
{
    /**
     * Constructor
     *
     * @param string    $anEventType the invalid event type
     * @param int       $code        (optional) an error code
     * @param Exception $previous    (optional) a previous exception
     */
    public function __construct($anEventType, $code = null, Exception $previous = null)
    {
        parent::__construct("Unrecognized event type [$anEventType]", $code, $previous);
    }
}

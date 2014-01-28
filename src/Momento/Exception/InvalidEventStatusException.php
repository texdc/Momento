<?php
/**
 * InvalidEventStatusException.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento\Exception;

use DomainException;

/**
 * Announces an invalid event status
 *
 * @see        \Momento\EventStatus::validate()
 * @package    Momento
 * @subpackage Exception
 */
class InvalidEventStatusException extends DomainException
{
}

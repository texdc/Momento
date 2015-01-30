<?php
/**
 * RemovalPreventedException.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento\Exception;

use RuntimeException;

/**
 * Announces that removing an event from an event store has been prevented
 *
 * @see    \Momento\EventStore::remove()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class RemovalPreventedException extends RuntimeException
{
}

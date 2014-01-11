<?php
/**
 * AppendingPreventedException.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento\Exception;

use RuntimeException;

/**
 * Announces that appending an event to an event store has been prevented
 *
 * @see    \Momento\EventStore::append()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class AppendingPreventedException extends RuntimeException
{
}

<?php
/**
 * AppendingPreventedException.php
 *
 * @copyright 2015 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace texdc\momento\exception;

use RuntimeException;

/**
 * Announces that appending an event to an event store has been prevented
 *
 * @see    texdc\momento\storage::append()
 * @author George D. Cooksey, III <texdc3@gmail.com>
 */
class AppendingPreventedException extends RuntimeException
{
}

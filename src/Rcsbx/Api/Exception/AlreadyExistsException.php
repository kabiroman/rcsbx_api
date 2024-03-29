<?php
/**
 * This file is part of the RCSBX/API module package.
 *
 * (c) Ruslan Kabirov <kabirovruslan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rcsbx\Api\Exception;

use Throwable;

/**
 * Class AlreadyExistsException
 * @package Rcsbx\Api\Exception
 */
class AlreadyExistsException extends \Exception
{
    /**
     * BadRequestException constructor.
     *
     * @param string|null    $message
     * @param Throwable|null $previous
     */
    public function __construct(string $message = null, Throwable $previous = null)
    {
        $message = ( ! $message) ? "Already Exists!" : $message;

        parent::__construct($message, 409, $previous);
    }
}
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
 * Class NotFoundException
 * @package Rcsbx\Api\Exception
 */
class NotFoundException extends \Exception
{
    /**
     * NotFoundException constructor.
     * @param string|null $message
     * @param Throwable|null $previous
     */
    public function __construct(string $message = null, Throwable $previous = null)
    {
        $message = (!$message) ? "Not Found!" : $message;

        parent::__construct($message, 404, $previous);
    }
}
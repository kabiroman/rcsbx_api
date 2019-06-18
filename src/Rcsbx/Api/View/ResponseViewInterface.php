<?php
/**
 * This file is part of the RCSBX/API module package.
 *
 * (c) Ruslan Kabirov <kabirovruslan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rcsbx\Api\View;


/**
 * Interface ResponseViewInterface
 * @package Rcsbx\Api\View
 */
interface ResponseViewInterface
{
    /**
     * @return string
     */
    public function getContent(): string;
}
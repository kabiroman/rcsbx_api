<?php
/**
 * This file is part of the RCSBX/API module package.
 *
 * (c) Ruslan Kabirov <kabirovruslan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rcsbx\Api\Controller;

use Rcsbx\Api\View\ResponseViewInterface;

/**
 * Class Response
 * @package Rcsbx\Api\Controller
 */
class Response
{
    /**
     * @var integer
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var ResponseViewInterface
     */
    private $view;

    /**
     * @var string
     */
    private $contentType = "application/json; charset=utf-8";

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param integer $code
     *
     * @return Response
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $message
     *
     * @return Response
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param array $data
     *
     * @return Response
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return ResponseViewInterface
     */
    public function getView(): ResponseViewInterface
    {
        return $this->view;
    }

    /**
     * @param ResponseViewInterface $view
     *
     * @return Response
     */
    public function setView(ResponseViewInterface $view): Response
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     *
     * @return Response
     */
    public function setContentType(string $contentType): Response
    {
        $this->contentType = $contentType;

        return $this;
    }
}
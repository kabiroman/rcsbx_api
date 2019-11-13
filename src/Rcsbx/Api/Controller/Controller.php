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

use Bitrix\Main\HttpRequest;

/**
 * Class Controller
 * @package Rcsbx\Api\Controller
 */
abstract class Controller
{
    /**
     * @var HttpRequest
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * Controller constructor.
     *
     * @param HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {
        $this->request  = $request;
        $this->response = new Response();
        $this->response->setCode(200);
    }

    /**
     * @param HttpRequest $request
     *
     * @return Controller
     */
    public function setRequest(HttpRequest $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return HttpRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Response $response
     *
     * @return Controller
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
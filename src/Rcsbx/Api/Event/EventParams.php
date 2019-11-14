<?php
/**
 * This file is part of the RCSBX/API module package.
 *
 * (c) Ruslan Kabirov <kabirovruslan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rcsbx\Api\Event;

use Bitrix\Main\HttpRequest;
use Rcsbx\Api\Controller\Response;

/**
 * Class EventParams
 *
 * @package Rcsbx\Api\Event
 */
class EventParams extends \ArrayObject
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var HttpRequest
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var mixed
     */
    private $result;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return EventParams
     */
    public function setType(string $type): EventParams
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     *
     * @return EventParams
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return HttpRequest
     */
    public function getRequest(): HttpRequest
    {
        return $this->request;
    }

    /**
     * @param HttpRequest $request
     *
     * @return EventParams
     */
    public function setRequest(HttpRequest $request): EventParams
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     *
     * @return EventParams
     */
    public function setResponse(Response $response): EventParams
    {
        $this->response = $response;

        return $this;
    }
}
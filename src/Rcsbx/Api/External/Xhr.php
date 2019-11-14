<?php
/**
 * This file is part of the Rcsbx package.
 *
 * (c) Ruslan Kabirov <kabirovruslan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Rcsbx\Api\External;

use Bitrix\Main\Event;
use Rcsbx\Api\Event\EventParams;

/**
 * Class Xhr
 *
 * @package Rcsbx\Api\External
 */
class Xhr
{
    /**
     * Returned data
     *
     * @var mixed
     */
    private $data;


    /**
     * Http response code
     *
     * @var string
     */
    private $httpCode = '';

    /**
     * Host name
     *
     * @var string
     */
    private $host = '';

    /**
     * Destination URL
     *
     * @var string
     */
    private $url = '';

    /**
     * @var string
     */
    private $login = '';

    /**
     * @var string
     */
    private $password = '';

    /**
     * @var string
     */
    private $security_key = '';

    /**
     * Header set
     *
     * @var array
     */
    private $header = [];

    /**
     * Post mode
     *
     * @var bool
     */
    private $post = false;

    /**
     * CURLOPT_RETURNTRANSFER Mode
     *
     * @var bool
     */
    private $return_transfer = true;

    /**
     * Content type
     *
     * @var string
     */
    private $content_type = 'application/json';

    /**
     * Post content
     *
     * @var mixed
     */
    private $content;

    /**
     * Progress bar
     *
     * @var array
     */
    private $progress = [];

    /**
     * No progress mode
     *
     * @var bool
     */
    private $no_progress = true;

    /**
     * Progress function
     *
     * @var mixed
     */
    private $progress_function = null;

    /**
     * Event log
     *
     * @var array
     */
    private $errors = [];

    /**
     * XHR constructor.
     *
     * @param      $url
     * @param bool $execute
     */
    public function __construct($url = '', $execute = false)
    {
        $this->setUrl($url);

        if ($execute) {
            $this->exec();
        }
    }

    /**
     * Curl execute
     *
     * @return bool
     */
    public function exec()
    {
        $this->onBeforeExec(new EventParams(['url' => $this->url]));

        try {
            if ($ch = curl_init()) {
                curl_setopt($ch, CURLOPT_URL, $this->getUrl());
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, $this->isReturnTransfer());
                curl_setopt($ch, CURLOPT_POST, $this->isPost());

                if ($this->isPost()) {
                    curl_setopt(
                        $ch,
                        CURLOPT_POSTFIELDS,
                        (is_array($this->getContent())) ? http_build_query($this->getContent()) : $this->getContent()
                    );
                }

                if ( ! empty($this->getHeader())) {
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeader());
                }

                curl_setopt($ch, CURLOPT_NOPROGRESS, $this->isNoProgress());

                if ( ! $this->isNoProgress() && $this->getProgressFunction() !== null) {
                    curl_setopt(
                        $ch,
                        CURLOPT_PROGRESSFUNCTION,
                        $this->getProgressFunction()
                    );
                }
                $this->setData(curl_exec($ch));
                $this->setHttpCode(curl_getinfo($ch, CURLINFO_HTTP_CODE));
                curl_close($ch);

                $this->onAfterExec(new EventParams(['url' => $this->url]));

                return true;

            } else {
                $arError = error_get_last();

                $e = new \Exception($arError['file'].'('.$arError['line'].'): '.$arError['message']);

                $this->addError($e);
            }
        } catch (\Exception $e) {
            $this->addError($e);
        }

        $this->onAfterExec(new EventParams(['url' => $this->url]));

        return false;
    }

    /**
     * Callback progress function
     *
     * @param $resource
     * @param $downloadSize
     * @param $downloaded
     * @param $uploadSize
     * @param $uploaded
     */
    public function progress($resource, $downloadSize, $downloaded, $uploadSize, $uploaded)
    {
        $this->progress[] = [
            'datetime'      => new \DateTime(),
            'resource'      => $resource,
            'download_size' => $downloadSize,
            'downloaded'    => $downloaded,
            'upload_size'   => $uploadSize,
            'uploaded'      => $uploaded
        ];
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getSecurityKey()
    {
        return $this->security_key;
    }

    /**
     * @param string $security_key
     *
     * @return $this
     */
    public function setSecurityKey($security_key)
    {
        $this->security_key = $security_key;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param array $header
     *
     * @return $this
     */
    public function setHeader(array $header)
    {
        $this->header = $header;

        return $this;
    }


    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->content_type;
    }

    /**
     * @param string $content_type
     *
     * @return $this
     */
    public function setContentType($content_type)
    {
        $this->content_type = $content_type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string|array $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param $arr
     *
     * @return $this
     */
    public function addContent($arr)
    {
        array_merge($this->content, $arr);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentString()
    {
        return json_encode($this->content);
    }

    /**
     * @return boolean
     */
    public function isPost()
    {
        return $this->post;
    }

    /**
     * @param boolean $bool
     *
     * @return $this
     */
    public function setPost($bool)
    {
        $this->post = $bool;

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param \Throwable $e
     */
    public function addError(\Throwable $e)
    {
        $this->errors[] = $e;
    }

    /**
     * @return bool
     */
    public function isReturnTransfer()
    {
        return $this->return_transfer;
    }

    /**
     * @param bool $return_transfer
     */
    public function setReturnTransfer($return_transfer)
    {
        $this->return_transfer = $return_transfer;
    }

    /**
     * @return array
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * @param array $progress
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;
    }

    /**
     * @return boolean
     */
    public function isNoProgress()
    {
        return $this->no_progress;
    }

    /**
     * @param boolean $value
     *
     * @return $this
     */
    public function setNoProgress($value)
    {
        $this->no_progress = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProgressFunction()
    {
        return $this->progress_function;
    }

    /**
     * @param mixed $progress_function
     *
     * @return $this
     */
    public function setProgressFunction($progress_function)
    {
        $this->progress_function = $progress_function;

        return $this;
    }

    /**
     * @return string
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @param string $httpCode
     */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;
    }

    /**
     * @param EventParams $params
     *
     * @return mixed
     */
    protected function onBeforeExec(EventParams $params)
    {
        return $this->eventSend('onBeforeExternalRequestExec', $params);
    }

    /**
     * @param EventParams $params
     *
     * @return mixed
     */
    protected function onAfterExec(EventParams $params)
    {
        return $this->eventSend('onAfterExternalRequestExec', $params);
    }

    /**
     * @param string      $type
     * @param EventParams $params
     *
     * @return mixed
     */
    protected function eventSend(string $type, EventParams $params)
    {
        $params['request'] = $this;

        $params->setType($type);

        $Event = new Event('rcsbx_api', $type, [$params]);
        $Event->send();

        return $params->getResult();
    }
}
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
 * Class ResponseView
 * @package Rcsbx\Api\View
 */
class ResponseView implements ResponseViewInterface
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $template;

    public function __construct(string $template, array $data = [])
    {
        $this->template = $template;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        $this->generateTemplate();
        return $this->content;
    }

    /**
     * @param string $content
     * @return ResponseView
     */
    public function setContent(string $content): ResponseView
    {
        $this->content = $content;
        return $this;
    }

    protected function generateTemplate()
    {
        $arPath = explode (':', $this->template);

        $pathFile = '';
        foreach ($arPath as $dir){
            $pathFile .= $dir . '/';
        }
        $pathFile .= 'template.php';
        $data = $this->data;

        ob_start();

        require_once __DIR__.'/../Resource/layout.php';

        $content = ob_get_contents();
        ob_end_clean();

        $this->setContent($content);
    }

}
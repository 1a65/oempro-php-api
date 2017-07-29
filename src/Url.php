<?php
/**
 * Created by PhpStorm.
 * User: raphaelgiovanini
 * Date: 27/07/17
 * Time: 23:06
 */

namespace Oempro;


class Url
{
    protected $url;

    public function __construct($url)
    {
        $this->setUrl($url);
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }
}
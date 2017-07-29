<?php
/**
 * Created by PhpStorm.
 * User: raphaelgiovanini
 * Date: 27/07/17
 * Time: 22:56
 */

namespace Oempro;


class Authentication
{
    /**
     * @var apiKey
     */
    protected $apiKey;

    /**
     * Authentication constructor.
     *
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->setApiKey($apiKey);
    }

    public function setApiKey($apiKey){
        $this->apiKey = $apiKey;
    }

    public function getApiKey(){
        return $this->apiKey;
    }

}
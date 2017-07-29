<?php
/**
 * Created by PhpStorm.
 * User: raphaelgiovanini
 * Date: 27/07/17
 * Time: 22:50
 */

namespace Oempro;


class Api
{
    /**
     * @var Session
     */
    public $session;
    /**
     * @var Rest
     */
    public $rest;
    /**
     * Api constructor.
     *
     * @param $user
     * @param $pwd
     */
    public function __construct($url, $apiKey)
    {
        $this->rest = new Rest($url, new Authentication($apiKey));
    }

    public function get($type, $params, $output = 'obj'){
        return $this->rest->run($type, $params, $output);
    }
}
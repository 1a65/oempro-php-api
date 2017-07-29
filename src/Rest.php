<?php
/**
 * Created by PhpStorm.
 * User: raphaelgiovanini
 * Date: 27/07/17
 * Time: 22:57
 */

namespace Oempro;

class Rest
{
    /**
     * @var null
     */
    public $response = null;

    /**
     * @var string
     */
    public $base = 'api.php?Command=[command]&ResponseFormat=JSON';

    /**
     * @var Url
     */
    public $url;

    /**
     * @var Authentication
     */
    public $auth;

    /**
     * Rest constructor.
     *
     * @param Authentication $auth
     * @param Url $url
     */
    public function __construct($urlApi, Authentication $auth)
    {
        $this->url = new Url($urlApi);
        $this->auth = $auth;
    }

    /**
     * @param string $command
     *
     * @return mixed
     */
    public function getBase($command = ''){
        return str_replace('[command]', $command, $this->base);
    }

    /**
     * @param string $command
     * @param array $params
     * @param string $return
     *
     * @return mixed
     */
    public function run($command = '', $params = [], $return = 'obj')
    {
        $stringParams = '';
        if(count($params)>0){
            if(isset($params['fields'])){
                foreach($params['fields'] AS $k => $v){
                    $params['fields[CustomField'.$k.']'] = $v;
                }
                unset($params['fields']);
            }
            $stringParams = '&' . http_build_query($params);
        }

        $session = '&ApiKey=' . $this->auth->getApiKey();

        $this->response = file_get_contents($url = $this->url->getUrl() . $this->getBase($command) . $session .$stringParams);
        echo $url;
//        var_dump($this->response);
        if($return == 'array'){
            return $this->toArray();
        }
        return $this->toObj();

    }

    /**
     * @return mixed
     */
    public function toObj()
    {
        return $this->json_decode(false);
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        return $this->json_decode(true);
    }

    /**
     * @param $bool
     *
     * @return mixed
     */
    private function json_decode($bool = false)
    {
        $return = json_decode($this->response, $bool);
        return $return;
    }
}
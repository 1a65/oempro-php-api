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
     * @param string $urlApi
     * @param Authentication $auth
     */
    public function __construct($urlApi, Authentication $auth)
    {
        $this->url  = new Url($urlApi);
        $this->auth = $auth;
    }

    /**
     * @param string $command
     *
     * @return mixed
     */
    public function getBase($command = '')
    {
        return str_replace('[command]', $command, $this->base);
    }

    /**
     * @param string $command
     * @param array $params
     * @param string $return
     *
     * @return mixed
     */
    public function run($command = '', $params = [], $return = 'obj', $method = 'get')
    {

        $stringParams = $this->traitmentParams($command, $params);;
        if($method=='get'){
            $this->getApi($command, $stringParams);
        }else{
            $this->postApi($stringParams);
        }
        
        if ($return == 'array') {
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

    /**
     * @param $command
     * @param $stringParams
     */
    private function getApi($command, $stringParams)
    {
        $this->response = file_get_contents($url = $this->url->getUrl() . $this->getBase($command) . $stringParams);
    }

    /**
     * @param $params
     */
    private function postApi($params)
    {
        $curl = curl_init($this->url->getUrl().'api.php');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        $this->response = curl_exec($curl);
        curl_close($curl);
    }

    /**
     * @param $command
     * @param $params
     *
     * @return string
     */
    private function traitmentParams($command, $params)
    {
        $stringParams = "Command=$command&ResponseFormat=JSON";

        if (isset($params['HTMLContent'])) {
            //minify html
            $params['HTMLContent'] = preg_replace("/\s\s+/", "", $params['HTMLContent']);
            $params['HTMLContent'] = preg_replace("/\r|\n/isU", "", $params['HTMLContent']);
            $params['HTMLContent'] = preg_replace("/\t/isU", "", $params['HTMLContent']);

            //fix broke post
            $stringParams .= '&HTMLContent=' . urlencode($params['HTMLContent']);
            unset($params['HTMLContent']);
        }

        if (count($params) > 0) {
            if (isset($params['fields'])) {
                foreach ($params['fields'] as $k => $v) {
                    if (strtolower($command) == 'subscriber.update') {
                        $params['fields[CustomField' . $k . ']'] = $v;
                    } else {
                        $params['CustomField' . $k . ''] = $v;
                    }
                }
                unset($params['fields']);
            }

            $stringParams .= '&' . http_build_query($params);
        }

        $stringParams .= '&ApiKey=' . (string) $this->auth->getApiKey();

        return $stringParams;
    }
}

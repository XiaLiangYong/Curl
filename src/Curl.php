<?php

namespace alibeibei\curl;

use alibeibei\curl\driver\Request;

/**
 * Created by PhpStorm.
 * User: xialiangyong
 * Date: 2017/7/19
 * Time: 14:07
 * @method get(String $url) get请求
 * @method post(String $name, array $postData) post请求
 * @method setCookie(String $cookies) 设置cookies
 * @method setProxy(String $proxy) 设置代理
 * @method setTime(String $time) 设置超时时间
 * @method setHeaders(array $headers) 设置header头
 * @method setIsHeader(bool $status) 设置是否需要返回头信息
 * @method setUserAgent(String $useragent) 设置userAget信息
 * @method getResult(String $result) 获取返回的完整信息
 * @method getCode(String $code) 获取返回的请求状态码
 * @method getResHeader(String $header) 获取返回的headers
 */
class Curl
{
    private static $instance = null;

    private static function getInstance()
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }
        self::$instance = new Request();
        return self::$instance;
    }

    /**
     * @param $method
     * @param $params
     * @return mixed
     */
    public function __call($method, $params)
    {
        return call_user_func_array([self::getInstance(), $method], $params);
    }


    public static function __callStatic($method, $args)
    {
        return call_user_func_array([self::getInstance(), $method], $args);
    }
}
<?php

namespace alibeibei\curl;

use alibeibei\curl\driver\Request;

/**
 * Created by PhpStorm.
 * User: xialiangyong
 * Date: 2017/7/19
 * Time: 14:07
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

    public function __call($method, $params)
    {
        return call_user_func_array([self::getInstance(), $method], $params);
    }


    public static function __callStatic($method, $args)
    {
        return call_user_func_array([self::getInstance(), $method], $args);
    }
}
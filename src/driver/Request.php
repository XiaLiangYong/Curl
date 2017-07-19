<?php

namespace alibeibei\curl\driver;

/**
 * Created by PhpStorm.
 * User: xialiangyong
 * Date: 2017/7/19
 * Time: 14:09
 */
class Request
{
    private $code;//代码请求code状态码
    private $result;//返回的body
    private $isHeader;//是否需要返回header
    private $resHeader;//返回的header
    private $headers = '';//初始化的headers
    private $userAgent;//useragent
    private $time = 30;//超时时间
    private $proxy = '';//代理
    private $cookie;//原始的cookie


    /**
     * @param mixed $cookie
     */
    public function setCookie($cookie)
    {
        $this->cookie = $cookie;
    }

    /**
     * @param string $proxy
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }


    /**
     * @param int $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @param mixed $setHeader
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getResHeader()
    {
        return $this->resHeader;
    }


    /**
     * @param mixed $isHeader
     */
    public function setIsHeader($isHeader)
    {
        $this->isHeader = $isHeader;
    }


    /**
     * @param mixed $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }


    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }


    /**
     * GET提交
     *
     * @param $url
     *
     * @return string
     * @throws \Exception
     */
    public function get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //是否需要返回头
        if ($this->isHeader) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }
        //设置请求头
        if ($this->headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        }
        //设置代理
        if ($this->proxy) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        }
        //设置userAgent
        if ($this->userAgent) {
            curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        }
        //设cookie
        if ($this->cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        }
        //设置超时时间
        if ($this->time) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->time);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if (curl_exec($ch) === false) {
            throw new \Exception(curl_error($ch));
            $data = '';
        } else {
            $data = curl_multi_getcontent($ch);
        }
        $this->result = $data;
        $this->code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $res = '';
        if ($this->isHeader) {
            $data = explode("\r\n\r\n", $data);
            if (count($data > 1)) {
                $resHeader = $data[0];
                $res = $data[1];
                $this->resHeader = $resHeader;
            }
        } else {
            $res = $data;
        }
        return $res;
    }

    /**
     * POST提交
     *
     * @param       $url
     * @param array $postData
     *
     * @return string
     * @throws \Exception
     */
    public function post($url, $postData = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //是否需要返回头
        if ($this->isHeader) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }
        //设置请求头
        if ($this->headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        }
        //设置代理
        if ($this->proxy) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        }
        //设置userAgent
        if ($this->userAgent) {
            curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        }
        //设cookie
        if ($this->cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        }
        //设置超时时间
        if ($this->time) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->time);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        if (curl_exec($ch) === false) {
            throw new \Exception(curl_error($ch));
            $data = '';
        } else {
            $data = curl_multi_getcontent($ch);
        }
        $this->result = $data;
        $this->code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $res = '';
        if ($this->isHeader) {
            $data = explode("\r\n\r\n", $data);
            if (count($data > 1)) {
                $resHeader = $data[0];
                $res = $data[1];
                $this->resHeader = $resHeader;
            }
        } else {
            $res = $data;
        }
        return $res;
    }
}
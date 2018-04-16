<?php

namespace Loganpc\Passport\Support;

class Transfer
{
    /**
     * Config constructor.
     *
     * @param array $config
     */
    public function __construct()
    {
    }

    /**
     * request请求（GET || POST）
     * @param string $url 请求的url
     * @param array $data 请求传输的数据
     * @param string $method 请求的方法：GET || POST
     * @return string 返回运行结果
     */
    public static function request($url, $data = array(), $method  = 'GET', $timeout = 1)
    {
        $ch = curl_init();
        $curlOptions = array(
            CURLOPT_URL				=>	$url,
            CURLOPT_CONNECTTIMEOUT	=>	1,
            CURLOPT_TIMEOUT			=>	$timeout,
            CURLOPT_RETURNTRANSFER	=>	true,
            CURLOPT_HEADER			=>	false,
            CURLOPT_FOLLOWLOCATION	=>	true,
            //CURLOPT_SSL_VERIFYPEER  => true, //默认开启HTTPS
        );

        if(false === strpos($url, 'https')) {
            $curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
        }
        else {
            $curlOptions[CURLOPT_SSL_VERIFYPEER] = true;
        }

        if('POST' === $method)
        {
            $curlOptions[CURLOPT_POST] = true;
            $curlOptions[CURLOPT_POSTFIELDS] = json_encode($data);
        }
        curl_setopt_array($ch, $curlOptions);
        //重试
        for($i = 0; $i <= 3; $i++)
        {
            $response = curl_exec($ch);
            $errno = curl_errno($ch);
            if(0 == $errno)
            {
                curl_close($ch);
                return $response;
            }
        }
        return false;
    }
}

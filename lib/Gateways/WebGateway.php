<?php

namespace Loganpc\Passport\Gateways;

use Loganpc\Passport\Support\Config;
use Loganpc\Passport\Support\Transfer;
use Loganpc\Passport\Exceptions\InvalidArgumentException;

class WebGateway
{
    /**
     * @var array
     */
    protected $user_config;

    /**
     * api
     */
    protected $gateway_sendcaptcha = '/api/v1.2/account/sendcaptcha';


    /**
     * [__construct description].
     *
     * @author Logan
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->user_config = new Config($config);
        if ($this->user_config->get('env')){
            $api_uri = $this->user_config->get($this->user_config->get('env').'_uri');
        }
        $this->user_config->set('uri', $api_uri);
    }

    /**
     * send captcha
     *
     * @author Logan
     *
     * @param array $config_biz
     *
     * @return array
     */
    public function sendCaptcha(array $param = [])
    {
        if (is_null($this->user_config->get('app_id'))) {
            throw new InvalidArgumentException('Missing Config -- [app_id]');
        }

        $sendRequest = [
            'appId'     => $this->user_config->get('app_id'),
            'phone' => $param['phone'],
            'type'  => $param['type'],
        ];

        //请求地址
        $url = $this->user_config->get('uri') . $this->gateway_sendcaptcha;

        $trans = new Transfer();
        return $trans->request($url, $sendRequest, 'POST');
    }
}

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
    protected $gateway_checkuser = 'api/checkuser';

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
        $this->user_config = [
            'uri' => $api_uri,
        ];
    }

    /**
     * pay a order.
     *
     * @author Logan
     *
     * @param array $config_biz
     *
     * @return array
     */
    public function sendSms(array $param = [])
    {
        if (is_null($this->user_config->get('app_id'))) {
            throw new InvalidArgumentException('Missing Config -- [app_id]');
        }

        $payRequest = [
            'appId'     => $this->user_config->get('app_id'),
            'timeStamp' => time(),
            'nonceStr'  => $this->createNonceStr(),
            'package'   => 'prepay_id='.$this->preOrder($param)['prepay_id'],
            'signType'  => 'MD5',
        ];
        $payRequest['paySign'] = $this->getSign($payRequest);

        $trans = new Transfer();
        return $trans->request($this->gateway_checkuser, $payRequest);
    }
}

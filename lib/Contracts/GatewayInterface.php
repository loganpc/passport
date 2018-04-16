<?php

namespace Loganpc\Passport\Contracts;

interface GatewayInterface
{
    /**
     * pay a order.
     *
     * @author Logan
     *
     * @param array $config_biz
     *
     * @return mixed
     */
    public function sendSms(array $config_biz);


}

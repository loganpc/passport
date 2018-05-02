<?php
namespace Loganpc\Passport;

//发送短信示例

use Loganpc\Passport\Passport;
//require '../lib/Passport.php';

$config = array(
    'env' => 'sandbox',
    'ak'  => 'xxx',
    'sk'  => 'xxx',
    'app_id' => 'xxx',
);

$passport = new Passport($config);

$param = [
    'phone' => '13810332846',
    'type'  => '1',
];

$result = $passport->gateway('web')->sendCaptcha($param);

var_dump($result);

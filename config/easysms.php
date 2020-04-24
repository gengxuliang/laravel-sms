<?php

/*
 * This file is part of the gengxuliang/laravel-sms.
 * (c) gengxuliang <gxl8566@163.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    // HTTP 请求的超时时间（秒）
    'timeout'  => 5.0,

    // 默认发送配置
    'default'  => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => [
            'aliyun',
        ],
    ],

    // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => 'sms.log',
        ],

        'aliyun' => [
            'access_key_id'     => env('SMS_ALIYUN_ACCESS_KEY_ID'),
            'access_key_secret' => env('SMS_ALIYUN_KEY_SECRET'),
            'sign_name'         => env('SMS_ALIYUN_SIGN_NAME'),
        ],
        // ...
    ],

];

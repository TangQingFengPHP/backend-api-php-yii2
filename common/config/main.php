<?php
return [
    'aliases' => [
    ],
    'timeZone' => 'Asia/Shanghai', // 设置时区为北京时间东八区
    'language' => 'zh-CN', // 设置语言为中文简体
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
];

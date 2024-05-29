<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'homeUrl'=>'http://crawler.test/',
    'name' => 'خزنده وب',
    'language' => 'fa-IR',
    'sourceLanguage'=>'fa-IR',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'PDate' => [
            'class' => 'yii\i18n\Formatter',
            'locale' => 'en@calendar=persian',
            'calendar' => IntlDateFormatter::TRADITIONAL,
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
            'timeFormat' => 'php:H:i:s',
            'defaultTimeZone' => 'Asia/Tehran',
            'timeZone' => 'Asia/Tehran',
        ],
    ],
];

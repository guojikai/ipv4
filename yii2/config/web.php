<?php
/**
 * web.php
 *
 * Author: Larry Li <larryli@qq.com>
 */

Yii::setAlias('@ipv4', dirname(dirname(__DIR__)));
// Yii::setAlias('@ipv4', (dirname(__DIR__) . '/vendor/larryli/ipv4');

$config = [
    'id' => 'ipv4',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        // ipv4 component
        'ipv4' => [
            'class' => 'larryli\ipv4\yii2\IPv4',
            'runtime' => '@app/runtime',
            'database' => 'larryli\ipv4\yii2\Database',
            // query config
            'providers' => [
                'monipdb',    // empty
                'qqwry',
                'full' => ['monipdb', 'qqwry'], // ex. 'monipdb', 'qqwry', ['qqwry', 'monipdb']
                'mini' => 'full',   // ex. ['monipdb', 'qqwry'], 'monipdb', 'qqwry', ['qqwry', 'monipdb']
                'china' => 'full',
                'world' => 'full',
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'ipv4',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => [],
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}
return $config;
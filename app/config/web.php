<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/npm-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => [
                        'https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js'
                    ]
                ],
                'yii\bootstrap5\BootstrapAsset' => [
                    'sourcePath' => null,
                    'css' => [
                        'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'
                    ]
                ],
                'yii\bootstrap5\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'js' => [
                        'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js'
                    ]
                ],
                'yii\gii\GiiAsset' => [
                    'depends' => [
                        'yii\web\JqueryAsset'
                    ]
                ]
            ],
        ],
        'request' => [
            'cookieValidationKey' => '16GGjJSDFuCPGWRRpFsEG9hNpY8wBrrd',
            'enableCsrfValidation' => true,
            'baseUrl' => '',
            'hostInfo' => 'http://127.0.0.1:8080',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:404',
                    ],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => require __DIR__ . '/routes.php',
            'hostInfo' => 'http://127.0.0.1:8080',
            'baseUrl' => '',
        ],
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'signer' => \sizeg\jwt\JwtSigner::HS256, // Константа (int)
            'signerKeyContents' => 'KXp4dDZqZjN1MHI5aGJvY2twZ3Vyc2h0bWl6',
            'signerKeyPassphrase' => '',
        ],
    ],
    'container' => [
        'singletons' => [
            'app\services\TrackValidatorInterface' => [
                'class' => 'app\services\TrackValidator',
            ],
            'app\services\StatusValidatorInterface' => [
                'class' => 'app\services\StatusValidator',
            ],

        ],
        'definitions' => [
            // Можно добавить другие зависимости, если нужно
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
        'generators' => [
            'model' => [
                'class' => 'yii\gii\generators\model\Generator',
                'templates' => [
                    'custom' => '@app/generators/model/default',
                ]
            ]
        ],
    ];
}

return $config;
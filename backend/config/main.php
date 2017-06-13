<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'language'=>'zh-CN',
    'defaultRoute'=>'goods',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            //默认登陆地址
            'loginUrl'=>['account/login'],
            //设置实现认证接口的类
            'identityClass' => 'backend\models\Admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'suffix'=>'.html',//伪静态后缀
            'rules' => [
            ],
        ],
        'qiniu'=>[
            'class'=>\backend\components\Qiniu::className(),
            'up_host' => 'http://up-z2.qiniu.com',
            'accessKey'=>'mgoLMhfeeY3i71Yhz5Iw7xW_C70-ec60T3we1uYC',
            'secretKey'=>'38ZjcZ26Z8iIZVsc06EIdGjnrWLJ00Ab5hdSuAtr',
            'bucket'=>'yiishop',
            'domain'=>'http://or9p5sqr2.bkt.clouddn.com/',
        ]

    ],
    'params' => $params,
];

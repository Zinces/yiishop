<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute'=>'good',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            //默认登陆地址
            'loginUrl'=>['member/login'],
            //设置实现认证接口的类
            'identityClass' => 'frontend\models\Member',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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

        'urlManager' => [  //地址管理
            'enablePrettyUrl' => true,//开启好看的地址
            'showScriptName' => false,  //是否显示index.php
           //'suffix'=>'.html',//伪静态后缀
            'rules' => [
            ],
        ],
        //配置短信组件
        'sms'=>[
            'class'=>\frontend\components\Sms::className(),
            'app_key'=>'24478750',
            'app_secret'=>'4c1ff1c8dfd7a160b846e545ce3de335',
            'sign_name'=>'钟佩吾网址',
            'template_code'=>'SMS_71505152',
        ]

    ],
    'params' => $params,
];

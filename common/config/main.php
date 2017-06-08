<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'=>'zh-CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager'=>[//认证数据库认证rbac的组件
            'class'=>\yii\rbac\DbManager::className(),
        ],
    ],
];

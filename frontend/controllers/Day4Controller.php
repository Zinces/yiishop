<?php
namespace frontend\controllers;
use frontend\models\Account;
use yii\filters\AccessControl;
use yii\web\Controller;

class Day4Controller extends Controller{
    public function actionUser(){
        //实例化user组件
        $user=\Yii::$app->user;
        var_dump($user->identity);
        var_dump($user->id);
        var_dump($user->isGuest);
    }
    public function actionLogin(){
        $user=\Yii::$app->user;
        $admin=Account::findOne(['id'=>5]);
        $user->login($admin);
        echo '11';
    }
    public function actionLogout(){
        \Yii::$app->user->logout();
    }
    public function actionAdd(){
        echo '1';
    }
    public function actionView(){
        echo '2';
    }
    public function behaviors()
    {
        return[
            'acf'=>[
                'class'=>AccessControl::className(),
                'only'=>['add','view'],//该过滤器作用的操作，默认所有
                'rules'=>[
                    [
                        'allow'=>true,//是否允许执行
                        'actions'=>['view'],//指定操作
                        'roles'=>['?'],//角色？未认证用户，@已认证用户
                    ],
                    [
                        'allow'=>true,//是否允许执行
                        'actions'=>['add'],//指定操作
                        'roles'=>['@'],//角色？未认证用户，@已认证用户
                        'matchCallback'=>function(){
                            //return \date('j')==5;//几号可以访问
                        }
                    ],
                    //其他都禁止执行
                ],
            ],
        ];
    }
}
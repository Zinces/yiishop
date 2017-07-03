<?php
namespace frontend\controllers;
use yii\web\Controller;

class WechatController extends Controller{
    public $enableCsrfValidation=false;
    public function actionIndex(){
        echo  'wechat';
    }
}
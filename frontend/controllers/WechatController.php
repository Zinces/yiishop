<?php
namespace frontend\controllers;
use yii\web\Controller;
use EasyWeChat\Foundation\Application;
class WechatController extends Controller{
    public $enableCsrfValidation=false;
    public function actionIndex(){
      $app = new Application(\Yii::$app->params['wechat']);
        // 从项目实例中得到服务端应用实例。
        $server = $app->server;
        $server->setMessageHandler(function ($message) {
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            //return "您好！欢迎关注我!";
            switch ($message->MsgType){
                case 'text':
                    //文本消息
                    return '你收到的消息：'.$message->Content;
                    break;
            }
        });


        $response = $app->server->serve();
// 将响应输出
        $response->send(); // Laravel 里请使用：return $response;
    }
}
<?php
namespace frontend\controllers;

use EasyWeChat\Message\News;
use frontend\models\Address;
use frontend\models\Member;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use EasyWeChat\Foundation\Application;
class WechatController extends Controller{
    //微信开发依赖的插件  easyWechat
    //关闭csrf验证
    public $enableCsrfValidation = false;
    public function actionIndex(){
    $app = new Application(\Yii::$app->params['wechat']);
        // 从项目实例中得到服务端应用实例。
        $server = $app->server;
        $server->setMessageHandler(function ($message) {
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            //return "您好！欢迎关注我!";
             switch ($message->MsgType){
                case 'event'://点击事件
                    if($message->Event=='CLICK'){
                        if ($message->EventKey=='cxsp'){
                            $news1 = new News([
                                'title'       => '智能液晶平板电视机',
                                'description' => '智能液晶平板电视机5折',
                                'url'         => 'http://zinces.huxiyan.site/address/good?id=27',
                                'image'       => 'http://or9p5sqr2.bkt.clouddn.com//upload/ad/22/ad22c06c3b759867cc53c534920b9bcf1498ec95.jpg',
                            ]);
                            $news2 = new News([
                                'title'       => '小米电视机',
                                'description' => '小米电视机6折.',
                                'url'         => 'http://zinces.huxiyan.site/address/good?id=18',
                                'image'       => 'http://or9p5sqr2.bkt.clouddn.com//upload/7e/7e/7e7ea9b5bfe3acd7102c8087ec14b8a5497b05b6.jpg',
                            ]);
                            $news3 = new News([
                                'title'       => '洛川苹果',
                                'description' => '洛川苹果买一送一',
                                'url'         => 'http://zinces.huxiyan.site/address/good?id=17',
                                'image'       => 'http://or9p5sqr2.bkt.clouddn.com//upload/b1/01/b1019e6448bff443ca54ca5cfd2e77066b5bf0f7.jpg',
                            ]);
                            $news4 = new News([
                                'title'       => '剃须刀',
                                'description' => '剃须刀7折',
                                'url'         => 'http://zinces.huxiyan.site/address/good?id=19',
                                'image'       => 'http://or9p5sqr2.bkt.clouddn.com//upload/aa/75/aa756ce85b3b321493b816ad611d0a2613835035.jpg',
                            ]);
                            $news5 = new News([
                                'title'       => '无锡阳山水蜜桃子',
                                'description' => '无锡阳山水蜜桃子买一送一',
                                'url'         => 'http://zinces.huxiyan.site/address/good?id=21',
                                'image'       => 'http://or9p5sqr2.bkt.clouddn.com//upload/48/f2/48f2a8380611d05710d50486cc70f4c06ae01e47.jpg',
                            ]);
                            return [$news1,$news2,$news3,$news4,$news5];
                        }
                    }
                    //return '接受到了'.$message->Event.'类型事件'.'key:'.$message->EventKey;
                    break;
                case 'text':
                    switch ($message->Content){
                        case '帮助':
                            return '您可以发送 优惠、解除绑定 等信息';
                        case '优惠':
                            $news1 = new News([
                                'title'       => '智能液晶平板电视机',
                                'description' => '智能液晶平板电视机5折',
                                'url'         => 'http://zinces.huxiyan.site/address/good?id=27',
                                'image'       => 'http://or9p5sqr2.bkt.clouddn.com//upload/ad/22/ad22c06c3b759867cc53c534920b9bcf1498ec95.jpg',
                            ]);
                            $news2 = new News([
                                'title'       => '小米电视机',
                                'description' => '小米电视机6折.',
                                'url'         => 'http://zinces.huxiyan.site/address/good?id=18',
                                'image'       => 'http://or9p5sqr2.bkt.clouddn.com//upload/7e/7e/7e7ea9b5bfe3acd7102c8087ec14b8a5497b05b6.jpg',
                            ]);
                            $news3 = new News([
                                'title'       => '洛川苹果',
                                'description' => '洛川苹果买一送一',
                                'url'         => 'http://zinces.huxiyan.site/address/good?id=17',
                                'image'       => 'http://or9p5sqr2.bkt.clouddn.com//upload/b1/01/b1019e6448bff443ca54ca5cfd2e77066b5bf0f7.jpg',
                            ]);
                            $news4 = new News([
                                'title'       => '剃须刀',
                                'description' => '剃须刀7折',
                                'url'         => 'http://zinces.huxiyan.site/address/good?id=19',
                                'image'       => 'http://or9p5sqr2.bkt.clouddn.com//upload/aa/75/aa756ce85b3b321493b816ad611d0a2613835035.jpg',
                            ]);
                            $news5 = new News([
                                'title'       => '无锡阳山水蜜桃子',
                                'description' => '无锡阳山水蜜桃子买一送一',
                                'url'         => 'http://zinces.huxiyan.site/address/good?id=21',
                                'image'       => 'http://or9p5sqr2.bkt.clouddn.com//upload/48/f2/48f2a8380611d05710d50486cc70f4c06ae01e47.jpg',
                            ]);
                            return [$news1,$news2,$news3,$news4,$news5];
                        case '解除绑定':
                            return '点击解绑：'.Url::to(['wechat/delopenid'],true);

                    }
                    return $message->Content;
              }
        });


        $response = $app->server->serve();
    // 将响应输出
    $response->send(); // Laravel 里请使用：return $response;
 }
    public function actionSetMenu(){
        $app = new Application(\Yii::$app->params['wechat']);
        $menu = $app->menu;
        $buttons = [
            [
                "type" => "click",
                "name" => "促销商品",
                "key"  => "cxsp"
            ],
            [
                "type" => "view",
                "name" => "在线商城",
                 "url"  => "http://zinces.huxiyan.site/"
            ],
            [
                "name"       => "个人中心",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "绑定账户",
                        "url"  => Url::to(['wechat/login'],true),
                    ],
                    [
                        "type" => "view",
                        "name" => "我的订单",
                        "url"  => Url::to(['wechat/order'],true),
                    ],
                    [
                        "type" => "view",
                        "name" => "收货地址",
                        "url"  => Url::to(['wechat/address'],true),
                    ],
                    [
                        "type" => "view",
                        "name" => "修改密码",
                        "url"  => Url::to(['wechat/repassword'],true),
                    ],

                ],
            ],
        ];
        $menu->add($buttons);
        $menus=$menu->all();
        var_dump($menus);
    }
    public function actionUser(){
        //发起网页授权
        $openid=\Yii::$app->session->get('openid');
        if ($openid == null){
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            $app = new Application(\Yii::$app->params['wechat']);
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send(); // Laravel 里请使用：return $response;
        }
        //var_dump($openid);

    }
    public function actionCallback(){
        $app = new Application(\Yii::$app->params['wechat']);
          $user = $app->oauth->user();
        // $user 可以用的方法:
        // $user->getId();  // 对应微信的 OPENID
        // $user->getNickname(); // 对应微信的 nickname
        // $user->getName(); // 对应微信的 nickname
        // $user->getAvatar(); // 头像网址
        // $user->getOriginal(); // 原始API返回的结果
        // $user->getToken(); // access_token， 比如用于地址共享时使用
        //var_dump($user->getId());
        \Yii::$app->session->set('openid',$user->getId());
        return $this->redirect([\Yii::$app->session->get('redirect')]);
    }
    public function actionOrder(){
        $openid=\Yii::$app->session->get('openid');
        if ($openid == null){
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            $app = new Application(\Yii::$app->params['wechat']);
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send(); // Laravel 里请使用：return $response;
        }
        //var_dump($openid);
         $member=Member::findOne(['openid'=>$openid]);
        if ($member ==null){
            return $this->redirect(['wechat/login']);
        }else{
            $orders=Order::findAll(['member_id'=>$member->id]);
            $orders_id=ArrayHelper::map($orders,'id','id');
            $models=OrderGoods::find()->where(['in','order_id',$orders_id])->all();
            return $this->renderPartial('order',['models'=>$models]);
        }

    }
    public function actionLogin(){

        $openid=\Yii::$app->session->get('openid');
        if ($openid == null){
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            $app = new Application(\Yii::$app->params['wechat']);
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send(); // Laravel 里请使用：return $response;
        }
        //var_dump($openid);
        $request=\Yii::$app->request;
        if (\Yii::$app->request->isPost){
            $user=Member::findOne(['username'=>$request->post('username')]);
            if ($user && \Yii::$app->security->validatePassword($request->post('password'),$user->password_hash)){
                \Yii::$app->user->login($user);
                Member::updateAll(['openid'=>$openid],'id='.$user->id);
                return $this->redirect(['wechat/order']);
             }
        }
        return $this->renderPartial('login');
    }
    public function actionTest(){
        \Yii::$app->session->removeAll();
    }
    public function actionAddress(){
        $openid=\Yii::$app->session->get('openid');
        if ($openid == null){
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            $app = new Application(\Yii::$app->params['wechat']);
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send(); // Laravel 里请使用：return $response;
        }
        //var_dump($openid);
        $member=Member::findOne(['openid'=>$openid]);
        if ($member ==null){
            return $this->redirect(['wechat/login']);
        }else{
            $models=Address::findAll(['user_id'=>$member->id]);
            return $this->renderPartial('address',['models'=>$models]);
        }
    }
    public function actionRepassword(){
        $openid=\Yii::$app->session->get('openid');
        if ($openid == null){
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            $app = new Application(\Yii::$app->params['wechat']);
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send(); // Laravel 里请使用：return $response;
        }
        //var_dump($openid);
        $request=\Yii::$app->request;
        if (\Yii::$app->request->isPost){
            $user=Member::findOne(['openid'=>$openid]);
            if ($user && \Yii::$app->security->validatePassword($request->post('old_password'),$user->password_hash)){
                $newpassword=\Yii::$app->security->generatePasswordHash($request->post('new_password'));
                Member::updateAll(['password_hash'=>$newpassword],'id='.$user->id);
                return $this->redirect(['wechat/order']);
            }
        }
        return $this->renderPartial('repassword');
    }
    public function actionDelopenid(){
        $openid=\Yii::$app->session->get('openid');
        if ($openid == null){
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            $app = new Application(\Yii::$app->params['wechat']);
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send(); // Laravel 里请使用：return $response;
        }
        $member=Member::findOne(['openid'=>$openid]);
        if ($member==null){
            return $this->redirect(['wechat/login']);
        }else{
            Member::updateAll(['openid'=>null],'id='.$member->id);
            return '解绑成功';
        }
    }
}
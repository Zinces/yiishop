<?php

namespace frontend\controllers;

use frontend\models\Cart;
use frontend\models\LoginForm;
use frontend\models\Member;


use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;

class MemberController extends \yii\web\Controller
{

    public $layout='member';
    public function actionRegister(){
        $model=new Member();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password);
            $model->created_at=time();
            $model->status=1;
            $model->save(false);
            \Yii::$app->session->setFlash('success','恭喜注册成功');
            return $this->redirect(['member/login']);
        }
        //var_dump($model->getErrors());exit;
        return $this->render('register',['model'=>$model]);
    }
    public function actionLogin(){
        $model=new LoginForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            \Yii::$app->session->setFlash('success','恭喜登陆成功');
            $user_id=\Yii::$app->user->id;
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            //var_dump($cookie);exit;
            if($cookie!=null) {
                $cart = unserialize($cookie->value);
                if ($cart != null) {
                     foreach ($cart as $goods_id=>$amount) {
                         //检查购物车里是否有该商品，如果有就累加
                         $cart=Cart::findOne(['goods_id'=>$goods_id,'member_id'=>$user_id]);
                         if($cart['goods_id']){
                             $cart['amount']+=$amount;
                         }else{
                             $cart=new Cart();
                             $cart->goods_id=$goods_id;
                             $cart->amount=$amount;
                             $cart->member_id=$user_id;
                         }
                         $cart->save();
                         //var_dump($cart->goods_id);
                         \Yii::$app->response->cookies->remove('cart');

                        }


                }
            }
            return $this->redirect(['good/index']);
        }
        return $this->render('login',['model'=>$model]);
    }
    public function actionLogout(){

        \Yii::$app->user->logout();
        return $this->redirect(['member/login']);


    }
    public function actionSendsms()
    {
        $tel=\Yii::$app->request->post('tel');
        if(!preg_match('/^1[34578]\d{9}$/',$tel)){
            echo '手机号码不正确';
            exit;
        }
        $code=rand(1000,9999);
       $re= \Yii::$app->sms->setNum($tel)->setParam(['code'=>$code])->send();
       if($re){
           //保存当前验证码 session MySQL redis  不能保存在cookie
           \Yii::$app->cache->set('tel_'.$tel,$code,5*60);
           echo 'success';
       }else{
           echo 'false';
       }
    }
}

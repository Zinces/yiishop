<?php

namespace frontend\controllers;

use frontend\models\Address;
use frontend\models\Brand;
use frontend\models\Cart;
use frontend\models\Goods;
use frontend\models\Goodsgallery;
use frontend\models\Locations;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

class AddressController extends \yii\web\Controller
{

    public $layout ='address';
    public function actionAddress(){
        $model=new Address();
        $models=Address::find()->all();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->status == 1){
                Address::updateAll(['status'=>0]);
            }
            $model->province_id=$model->province;
            $model->city_id=$model->city;
            $model->district_id=$model->district;
            $model->save();
            \Yii::$app->session->setFlash('success','添加地址成功');
            return $this->redirect(['address/address']);
        }
        return $this->render('index',['model'=>$model,'models'=>$models]);
    }
    public function actionEdit($id){
        $model=Address::findOne(['id'=>$id]);
        $models=Address::find()->all();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->status == 1){
                 Address::updateAll(['status'=>0]);
            }
            $model->province_id=$model->province;
            $model->city_id=$model->city;
            $model->district_id=$model->district;
            $model->save();
            //\Yii::$app->session->setFlash('success','添加地址成功');
            return $this->redirect(['address/address']);
        }
        return $this->render('address',['model'=>$model,'models'=>$models]);
    }
    public function actionDel($id){
        $model=Address::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['address/address']);
    }
    public function actionShe($id){
        $model=Address::findOne(['id'=>$id]);
        if($model->status == 0){
            Address::updateAll(['status'=>0]);
        }
        $model->status=1;
        $model->save();
        return $this->redirect(['address/address']);
    }
    public function actions()
    {
        $actions=parent::actions();
        $actions['get-region']=[
            'class'=>\chenkby\region\RegionAction::className(),
            'model'=>Locations::className()
        ];
        return $actions;
    }
    public function actionList($id){
        $models=Brand::find()->all();
        $goods=Goods::findAll(['good_category_id'=>$id]);
        //var_dump($goods);
        return $this->render('list',['models'=>$models,'goods'=>$goods]);
    }
    public function actionGood($id){
        $model=Goods::findOne(['id'=>$id]);
        $models=Goodsgallery::findAll(['goods_id'=>$id]);
        return $this->render('good',['model'=>$model,'models'=>$models]);
    }
    public function actionAddgoods(){
       //接收数据;
        $goods_id=\Yii::$app->request->post('goods_id');
        $amount=\Yii::$app->request->post('amount');
        $goods=\backend\models\Goods::findOne(['id'=>$goods_id]);
        if($goods==null){
            throw new NotFoundHttpException('商品不存在');
        }
        //判读是否登陆
        if (\Yii::$app->user->isGuest){
            //先获取之前的购物车里的商品
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            if($cookie==null){
                $cart=[];
            }else{
                $cart=unserialize($cookie->value);
            }
            //将商品的id和数量放在cookie中
            $cookies=\Yii::$app->response->cookies;
            //检查购物车里是否有该商品，如果有就累加
            if(key_exists($goods->id,$cart)){
                $cart[$goods_id]+=$amount;
            }else{
                $cart[$goods_id]=$amount;
            }

            $cookie =new Cookie(['name'=>'cart','value'=>serialize($cart)]);
            $cookies->add($cookie);
        }else{
            //登陆后
            $cart=Cart::findOne(['goods_id'=>$goods_id]);
            $user_id=\Yii::$app->user->id;
            if($cart['goods_id']){
                 $cart['amount']+=$amount;
            }else{
                $cart=new Cart();
                $cart->goods_id=$goods_id;
                $cart->amount=$amount;
                $cart->member_id=$user_id;
            }
                $cart->save();
        }
        return $this->redirect(['address/cart']);
    }
    public function actionCart(){
        $this->layout='cart';
        if (\Yii::$app->user->isGuest){
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            if ($cookie==null){
                $cart=[];
            }else{
               $cart=unserialize($cookie->value);
            }
            $models=[];
            foreach ($cart as $goods_id=>$amount){
                $goods=\backend\models\Goods::findOne(['id'=>$goods_id])->attributes;
                $goods['amount']=$amount;
                $models[]=$goods;
            }

        }else{
            //数据库中
            $user_id=\Yii::$app->user->id;
            $carts=Cart::find()->where(['member_id'=>$user_id])->asArray()->all();
            $models=[];
            foreach ($carts as $cart){
                $goods=Goods::findOne(['id'=>$cart['goods_id']])->attributes;
                $goods['amount']=$cart['amount'];
                $models[]=$goods;
            }

     }

        return $this->render('cart',['models'=>$models]);
    }
    public function actionUpdatecart(){
        $goods_id=\Yii::$app->request->post('goods_id');
        $amount=\Yii::$app->request->post('amount');
        $goods=\backend\models\Goods::findOne(['id'=>$goods_id]);
        if($goods==null){
            throw new NotFoundHttpException('商品不存在');
        }
        if(\Yii::$app->user->isGuest){
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            if($cookie==null){
                $cart=[];
            }else{
                $cart=unserialize($cookie->value);
            }
            $cookies=\Yii::$app->response->cookies;
            if ($amount){
                $cart[$goods_id]=$amount;
            }else{
                if(key_exists($goods['id'],$cart)) unset($cart[$goods_id]);
            }

            $cookie=new Cookie(['name'=>'cart','value'=>serialize($cart)]);
            $cookies->add($cookie);
        }else{
           // $user_id=\Yii::$app->user->id;
            $cart=Cart::findOne(['goods_id'=>$goods_id]);
            if($amount){
                $cart['amount']=$amount;
                $cart->save();
                  }else{
                 $cart->delete();
                 }
          }
    }
}

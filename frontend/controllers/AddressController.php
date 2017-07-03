<?php

namespace frontend\controllers;

use backend\components\SphinxClient;
use frontend\models\Address;
use frontend\models\Brand;
use frontend\models\Cart;
use frontend\models\Goods;
use frontend\models\Goodsgallery;
use frontend\models\Locations;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class AddressController extends \yii\web\Controller
{

    public $layout ='address';
    public function actionAddress(){
        if(\Yii::$app->user->isGuest){
            return $this->redirect(['member/login']);
        }
        $model=new Address();
        $user_id=\Yii::$app->user->id;
        $models=Address::find()->where(['user_id'=>$user_id])->all();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->status == 1){
                Address::updateAll(['status'=>0]);
            }
            $model->province_id=$model->province;
            $model->city_id=$model->city;
            $model->district_id=$model->district;
            $model->user_id=$user_id;
            $model->save();
            \Yii::$app->session->setFlash('success','添加地址成功');
            return $this->redirect(['address/address']);
        }
        return $this->render('index',['model'=>$model,'models'=>$models]);
    }
    public function actionEdit($id){
        $model=Address::findOne(['id'=>$id]);
        $user_id=\Yii::$app->user->id;
        $models=Address::find()->where(['user_id'=>$user_id])->all();
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
        return $this->render('index',['model'=>$model,'models'=>$models]);
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
            $user_id=\Yii::$app->user->id;
            $cart=Cart::findOne(['goods_id'=>$goods_id,'member_id'=>$user_id]);
            if($cart){
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
           $user_id=\Yii::$app->user->id;
           $cart=Cart::findOne(['goods_id'=>$goods_id,'member_id'=>$user_id]);
            if($amount){
                $cart['amount']=$amount;
                $cart->save();
                  }else{
                 $cart->delete();
                 }
          }
    }
    public function actionOrder(){
        if(\Yii::$app->user->isGuest){
            return $this->redirect(['member/login']);
        }
        $this->layout='cart';
        $user_id=\Yii::$app->user->id;
        $address=Address::find()->where(['user_id'=>$user_id])->all();
        $carts=Cart::find()->where(['member_id'=>$user_id])->all();
        $request=\Yii::$app->request;
        if($request->isPost){
            $address_id=$request->post('address_id');
            $delivery_id=$request->post('delivery');
            $payment_id=$request->post('payment');
            $total=$request->post('total');
            //var_dump($total);exit;

            $address=Address::findOne(['id'=>$address_id]);
            //var_dump($address);
            $delivery=Order::$sendway[$delivery_id];
            $payment=Order::$payway[$payment_id];
            $status=Order::$statusOptions;
            //var_dump($status);exit;

            $model=new Order();
            $model->member_id=$user_id;
            $model->name=$address->name;
            $model->province=$address->location->name;
            $model->city=$address->location1->name;
            $model->area=$address->location2->name;
            $model->address=$address->address;
            $model->tel=$address->tel;
            $model->delivery_id=$delivery_id;
            $model->delivery_name=$delivery['delivery_name'];
            $model->delivery_price=$delivery['delivery_price'];
            //var_dump($model->delivery_price);exit;
            $model->payment_id=$payment_id;
            $model->payment_name=$payment['payment_name'];
            $model->total=$total;
            $model->status=1;
            //var_dump($model->total);exit;
            $model->create_time=time();

            $transaction=\Yii::$app->db->beginTransaction();
            try{
                $model->save(false);
                foreach ($carts as $cart){
                    $goods=\backend\models\Goods::findOne(['id'=>$cart->goods_id]);
                    if($goods==null){
                        throw new HttpException($goods->name.'商品已售空');
                    }
                    if($goods->stock<$cart->amount){
                        throw new HttpException($goods->name.'商品库存不足');
                    }
                    $mode=new OrderGoods();
                    $mode->order_id=$model->id;
                    $mode->goods_id=$cart->goods_id;
                    $mode->goods_name=$cart->goods->name;
                    $mode->logo=$cart->goods->logo;
                    $mode->price=$cart->goods->shop_price;
                    $mode->amount=$cart->amount;
                    $mode->total=$cart->amount*$cart->goods->shop_price;                                 $mode->save();
                    //减少库存
                    $goods->stock-=$cart->amount;
                    $goods->save();
                    Cart::deleteAll(['member_id'=>$user_id]);
                 }
                $transaction->commit();
            }catch (Exception $e){
                $transaction->rollBack();
            }




         return $this->redirect(['address/success']);

        }
     return $this->render('order',['address'=>$address,'carts'=>$carts]);
    }
    public function actionSuccess(){
        $this->layout='cart';
        if (\Yii::$app->user->isGuest){
            return $this->redirect(['member/login']);
        }
        $user_id=\Yii::$app->user->id;
        $model=Cart::find()->where(['member_id'=>$user_id])->all();
        //var_dump($model);exit;
        return $this->render('success');
  }
    public function actionOrindex(){
        $this->layout='cart';
        if (\Yii::$app->user->isGuest){
            return $this->redirect(['member/login']);
        }
        $user_id=\Yii::$app->user->id;
        $models=Order::find()->where(['member_id'=>$user_id])->all();

        //var_dump($models);exit;
        //$models=OrderGoods::find()->where(['order_id'=>$order_id])->all();
        return $this->render('orindex',['models'=>$models]);
    }
    public function actionSousuo(){
        $query=\backend\models\Goods::find();
        $models=Brand::find()->all();
        if ($keyword=\Yii::$app->request->get('keyword')){

            $cl = new SphinxClient();
            $cl->SetServer ( '127.0.0.1', 9312);
            $cl->SetConnectTimeout ( 10 );
            $cl->SetArrayResult ( true );
            $cl->SetMatchMode ( SPH_MATCH_ALL);
            $cl->SetLimits(0, 1000);
            $res = $cl->Query($keyword, 'goods');//shopstore_search
            //var_dump($res);exit;
            if(!isset($res['matches'])){
                $query->where(['id'=>0]);
            }else{
                //var_dump($res);exit;
                $ids=ArrayHelper::map($res['matches'],'id','id');
                $query->where(['in','id',$ids]);
            }

        }
        $goods=$query->all();
        if($keyword !=null) {
            $keywords = array_keys($res['words']);
            $options = array(
                'before_match' => '<span style="color:#ff7534;">',
                'after_match' => '</span>',
                'chunk_separator' => '...',
                'limit' => 80, //如果内容超过80个字符，就使用...隐藏多余的的内容
            );
            foreach ($goods as $index => $item) {
                $name = $cl->BuildExcerpts([$item->name], 'goods', implode(',', $keywords), $options); //使用的索引不能写*，关键字可以使用空格、逗号等符号做分隔，放心，sphinx很智能，会给你拆分的
                $goods[$index]->name = $name[0];
            }
        }
        return $this->render('list',['models'=>$models,'goods'=>$goods]);
    }
}

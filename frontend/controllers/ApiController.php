<?php
namespace frontend\controllers;
use backend\models\Article;
use backend\models\Article_category;
use backend\models\Goodcategory;
use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Member;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\captcha\CaptchaAction;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Response;
use yii\web\UploadedFile;

class ApiController extends Controller{
    public $enableCsrfValidation=false;
    public $layout='member';
    public function init()
    {
        \Yii::$app->response->format=Response::FORMAT_JSON;
        parent::init();

    }
    public function actionRegisterMember(){

        //\Yii::$app->response->format=Response::FORMAT_JSON;
        $request=\Yii::$app->request;
        if($request->isPost){
            $member=new Member();
            $member->username=$request->post('username');
            $member->password_hash=\Yii::$app->security->generatePasswordHash($request->post('password'));
            $member->tel=$request->post('tel');
            $member->email=$request->post('email');
            $member->code=$request->post('code');
            $member->status=1;
            if ($member->validate()){
                $member->save(false);
                return['status'=>1,'msg'=>'注册成功'];
            }else{
                return['status'=>0,'msg'=>$member->getErrors()];
            }
        }else{
            return ['status'=>0,'msg'=>'请求方式不对'];
        }
    }
    public function actionMemberLogin(){
        $request=\Yii::$app->request;
        if ($request->isPost){
            $username=$request->post('username');
            $user=Member::findOne(['username'=>$username]);
            if ($user){
                $password=$request->post('password');
                if (\Yii::$app->security->validatePassword($password,$user->password_hash)){
                    \Yii::$app->user->login($user);
                    return['status'=>1,'msg'=>'登录成功'];
                }else{
                    return['status'=>0,'msg'=>'用户密码不正确'];
                }
            }else{
                return['status'=>0,'msg'=>'用户密码不正确'];
            }
       }else{
            return['status'=>0,'msg'=>'请求方式不对'];
        }
    }
    public function actionPasswordModify(){
        if (\Yii::$app->user->isGuest){
            return['status'=>0,'msg'=>'请先登录'];
        }else{
            $id=\Yii::$app->user->id;
            $user=Member::findOne(['id'=>$id]);
            if ($user){
                $request=\Yii::$app->request;
                if ($request->isPost){
                    $old_password=$request->post('old_password');
                    $new_password=$request->post('new_password');
                    if (\Yii::$app->security->validatePassword($old_password,$user->password_hash)){
                        $user->password_hash=\Yii::$app->security->generatePasswordHash($new_password);
                        $user->save();
                        return['status'=>1,'msg'=>'修改密码成功'];
                    }else{
                        return['status'=>0,'msg'=>'账号密码不存在'];
                    }
            }else{
                    return['status'=>0,'msg'=>'账号密码不存在'];
                }

            }else{
                return['status'=>0,'msg'=>'请求方式不对'];
            }
        }
    }
    public function actionGetUser(){
        if (\Yii::$app->user->isGuest){
            return['status'=>0,'msg'=>'请先登录'];
        }else{
           return['status'=>1,'msg'=>'','data'=>\Yii::$app->user->identity->toArray()];
        }
    }
    public function actionAddressAdd(){
        if (\Yii::$app->user->isGuest){
            return['status'=>0,'msg'=>'请先登录'];
        }else{
            $user_id=\Yii::$app->user->id;
            $request=\Yii::$app->request;
            if($request->isPost){
                $model=new Address();
                $model->name=$request->post('name');
                $model->user_id=$user_id;
                $model->address=$request->post('address');
                $model->tel=$request->post('tel');
                $model->province_id=$request->post('province');
                $model->city_id=$request->post('city');
                $model->district_id=$request->post('district');
                if ($model->validate()){
                    $model->save();
                    return['status'=>1,'msg'=>'添加地址成功'];
                }else{
                    return['status'=>0,'msg'=>$model->getErrors()];
                }
            }else{
                return['status'=>0,'msg'=>'请求方式不对'];
            }
        }
    }
    public function actionAddressEdit($id){
        if (\Yii::$app->user->isGuest){
            return['status'=>0,'msg'=>'请先登录'];
        }else{
            $user_id=\Yii::$app->user->id;
            $request=\Yii::$app->request;
            $model=Address::findOne(['user_id'=>$user_id,'id'=>$id]);
            if ($request->isPost){
                $model->name=$request->post('name');
                $model->address=$request->post('address');
                $model->tel=$request->post('tel');
                $model->province_id=$request->post('province');
                $model->city_id=$request->post('city');
                $model->district_id=$request->post('district');
                if ($model->validate()){
                    $model->save();
                    return['status'=>1,'msg'=>'修改地址成功'];
                }else{
                    return['status'=>0,'msg'=>$model->getErrors()];
                }
            }else{
                return['status'=>0,'msg'=>'请求方式不对'];
            }
       }
    }
    public function actionAddressDel($id){
        if (\Yii::$app->user->isGuest){
            return['status'=>0,'msg'=>'请登录'];
        }else{
            $user_id=\Yii::$app->user->id;
            $model=Address::findOne(['id'=>$id,'user_id'=>$user_id]);
            //var_dump($model);exit;
            if ($model){
                $model->delete();
                return['status'=>1,'msg'=>'删除地址成功'];
            }else{
                return['status'=>0,'msg'=>'地址不存在'];
            }
        }
    }
    public function actionAddressList(){
        if (\Yii::$app->user->isGuest){
            return['status'=>0,'msg'=>'请先登录'];
        }else{
            $user_id=\Yii::$app->user->id;
            $models=Address::find()->where(['user_id'=>$user_id])->all();
            if ($models){
                return['status'=>1,'msg'=>$models];
            }else{
                return['status'=>0,'msg'=>'会员没有地址，请添加'];
            }
        }
    }
    public function actionGetGoodCategory(){
        $models=Goodcategory::find()->all();
        if ($models){
            return ['status'=>1,'msg'=>$models];
        }else{
            return['status'=>0,'msg'=>'商品分类不存在'];
        }
    }
    public function actionGetCategorySon(){
        $id=\Yii::$app->request->get('id');
        if ($id){
             $model=Goodcategory::findOne(['id'=>$id]);
            if ($model){
                 $models=Goodcategory::find()->where(['>','lft',$model['lft']])->andWhere(['<','rgt',$model['rgt']])->andWhere(['=','tree',$model['tree']])->all();

                 if ($models){
                     return['status'=>1,'msg'=>$models];
                 }else{
                     return['status'=>0,'msg'=>'这是最低级分类'];
                 }

             }else{
                 return['status'=>0,'msg'=>'商品分类不存在'];
             }
        }else{
            return['status'=>0,'msg'=>'商品分类不存在'];
        }
    }
    public function actionGetCategoryParent(){
        $id=\Yii::$app->request->get('id');
        if ($id){
            $model=Goodcategory::findOne(['id'=>$id]);
            $model=Goodcategory::findOne(['tree'=>$model['tree'],'id'=>$model['parent_id']]);
            if ($model){
                return['status'=>1,'msg'=>$model];
            }else{
                return['status'=>0,'msg'=>'这是顶级分类'];
            }

        }else{
            return['status'=>0,'msg'=>'商品分类不存在'];
        }
    }
    public function actionGetGoodsToCategory(){
        $id=\Yii::$app->request->get('id');
        if ($id){
            $model=Goodcategory::findOne(['id'=>$id]);
            if ($model){
                $models=Goodcategory::find()->where(['>=','lft',$model['lft']])->andWhere(['<=','rgt',$model['rgt']])->andWhere(['=','tree',$model['tree']])->all();
                if ($models){
                    $ids=ArrayHelper::map($models,'id','id');
                    $goods=Goods::find()->where(['in','good_category_id',$ids])->all();
                    return['status'=>1,'msg'=>$goods];
                }else{
                    return['status'=>0,'msg'=>'这是最低级分类'];
                }

            }else{
                return['status'=>0,'msg'=>'商品分类不存在'];
            }
        }else{
            return['status'=>0,'msg'=>'商品分类不存在'];
        }
    }
    public function actionGetGoodsToBrand(){
        $request=\Yii::$app->request;
        if($request->isGet){
            $id=$request->get('id');
            if ($id){
                $goods=Goods::find()->where(['brand_id'=>$id])->all();
                if ($goods){
                    return['status'=>1,'msg'=>$goods];
                }else{
                    return['status'=>0,'msg'=>'该品牌的商品还没有'];
                }
            }else{
                return['status'=>0,'msg'=>'品牌不存在'];
            }
        }else{
            return['status'=>0,'msg'=>'传值方式不对'];
        }
    }
    public function actionGetArticleCategory(){
        $models=Article_category::find()->all();
        if ($models){
            return['status'=>1,'msg'=>$models];
        }else{
            return['status'=>0,'msg'=>'文章分类还没有'];
        }
    }
    public function actionGetArticleToCategory(){
        $request=\Yii::$app->request;
        if ($request->isGet){
            $id=$request->get('id');
            if ($id){
                $models=Article::find()->where(['article_category_id'=>$id])->all();
                if ($models){
                    return['status'=>1,'msg'=>$models];
                }else{
                    return['status'=>0,'msg'=>'文章分类不存在'];
                }
            }else{
                return['status'=>0,'msg'=>'文章分类不存在'];
            }
        }else{
            return['status'=>0,'msg'=>'文章分类不存在'];
        }
    }
    public function actionGetCategoryToArticle(){
        $request=\Yii::$app->request;
        if ($request->isGet){
            $id=$request->get('id');
            if ($id){
                $models=Article::find()->where(['id'=>$id])->asArray()->all();
                //var_dump($models[0]['article_category_id']);exit;
                $model=Article_category::findOne(['id'=>$models[0]['article_category_id']]);
                //var_dump($models);exit;
                if ($model){
                    return['status'=>1,'msg'=>$model];
                }else{
                    return['status'=>0,'msg'=>'文章不存在'];
                }
            }else{
                return['status'=>0,'msg'=>'文章不存在'];
            }
        }else{
            return['status'=>0,'msg'=>'文章不存在'];
        }
    }
    public function actionCartAdd(){
        $request=\Yii::$app->request;
        if ($request->isPost){
            $amount=$request->post('amount');
            $goods_id=$request->post('goods_id');
            $goods=Goods::findOne(['id'=>$goods_id]);
            if ($goods==null){
                return['status'=>0,'msg'=>'商品不存在'];
            }
            if (\Yii::$app->user->isGuest){
                $cookies=\Yii::$app->request->cookies;
                $cookie=$cookies->get('cart');
                if ($cookie==null){
                    $cart=[];
                }else{
                    $cart=unserialize($cookie->value);
                }
                $cookies=\Yii::$app->response->cookies;
                if (key_exists($goods_id,$cart)){
                    $cart[$goods_id]+=$amount;
                }else{
                    $cart[$goods_id]=$amount;
                }
               $cookie=new Cookie(['name'=>'cart','value'=>$cart]);
                $cookies->add($cookie);
            }else{
                $user_id=\Yii::$app->user->id;
                $cart=Cart::findOne(['member_id'=>$user_id,'goods_id'=>$goods_id]);
                if ($cart){
                    $cart['amount']+=$amount;
                }else{
                    $cart=new Cart();
                    $cart->amount=$amount;
                    $cart->member_id=$user_id;
                    $cart->goods_id=$goods_id;
                }
                $cart->save();
                return['status'=>0,'msg'=>'添加购物车成功'];
            }
        }else{
            return['status'=>0,'msg'=>'请求方式不对'];
        }

    }
    public function actionCartEdit(){
        if (\Yii::$app->user->isGuest){
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            if ($cookie==null){
                $cart=[];
            }else{
                $cart=unserialize($cookie->value);
            }
            $model=[];
            foreach ($cart as $goods_id=>$amount){
                $goods=\backend\models\Goods::findOne(['id'=>$goods_id])->attributes;
                $goods['amount']=$amount;
                $models[]=$goods;
            }
            }else{
            $request=\Yii::$app->request;
            if ($request->isPost){
                $member_id=\Yii::$app->user->id;
                $goods_id=$request->post('goods_id');
                //$goods=Goods::findOne(['id'=>$goods_id]);
                $cart=Cart::findOne(['goods_id'=>$goods_id,'member_id'=>$member_id]);
                if ($cart){
                    $cart->amount=$request->post('amount');
                    $cart->save();
                    return['status'=>0,'msg'=>'修改数量成功'];
                }else{
                    return['status'=>0,'msg'=>'订单不存在'];
                }

            }else{
                return['status'=>0,'msg'=>'请求方式不对'];
            }
        }
    }
    public function actionCartDel(){
        if(\Yii::$app->user->isGuest){
            return['status'=>0,'msg'=>'请先登录'];
        }else{
            $member_id=\Yii::$app->user->id;
            $request=\Yii::$app->request;
            if ($request->isPost){
                $goods_id=$request->post('goods_id');
                $cart=Cart::findOne(['member_id'=>$member_id,'goods_id'=>$goods_id]);
                $cart->delete();
                return['status'=>0,'msg'=>'删除订单成功'];
            }else{
                return['status'=>0,'msg'=>'请求方式不对'];
            }
        }
    }
    public function actionCartsDel(){
        if (\Yii::$app->user->isGuest){
            return['status'=>0,'msg'=>'请先登录'];
        }else{
            $memeber_id=\Yii::$app->user->id;
            $carts=Cart::deleteAll(['member_id'=>$memeber_id]);
            if ($carts){
                return['status'=>0,'msg'=>'清空购物车成功'];
            }else{
                return['status'=>0,'msg'=>'订单不存在'];
            }
        }
    }
    public function actionCartsGet(){
        if (\Yii::$app->user->isGuest){
        return['status'=>0,'msg'=>'请先登录'];
        }else{
            $member_id=\Yii::$app->user->id;
            $carts=Cart::findAll(['member_id'=>$member_id]);
            if ($carts){
                $ids=ArrayHelper::map($carts,'id','goods_id');
                $goods=Goods::find()->where(['in','id',$ids])->all();
                return['status'=>0,'msg'=>$goods];
            }else{
                return['status'=>0,'msg'=>'订单还没有'];
            }
        }
    }
    public function actionGetPay(){
        if (\Yii::$app->user->isGuest){
            return['status'=>0,'msg'=>'请先登录'];
        }else{
            $pay=Order::$payway;
            return['stauts'=>1,'msg'=>$pay];
        }
    }
    public function actionGetDelivery(){
        if (\Yii::$app->user->isGuest){
            return['status'=>0,'msg'=>'请先登录'];
        }else{
            $send=Order::$sendway;
            return['stauts'=>1,'msg'=>$send];
        }
    }
    public function actionSubmitOrder(){
        if (\Yii::$app->user->isGuest){
         return['status'=>0,'msg'=>'请先登录'];
        }else{
            $request=\Yii::$app->request;
            if ($request->isPost){
                $model=new Order();
                $model->member_id=\Yii::$app->user->id;
                $model->name=$request->post('name');
                $model->province=$request->post('province');
                $model->city=$request->post('city');
                $model->area=$request->post('area');
                $model->address=$request->post('address');
                $model->tel=$request->post('tel');
                $delivery_id=$request->post('delivery');
                $payment_id=$request->post('payment');
                $model->delivery_id=$delivery_id;
                $model->delivery_name=Order::$sendway[$delivery_id]['delivery_name'];
                $model->delivery_price=Order::$sendway[$delivery_id]['delivery_price'];
                $model->payment_id=$payment_id;
                $model->payment_name=Order::$payway[$payment_id]['payment_name'];
                $model->total=$request->post('total');
                $model->status=1;
                $model->create_time=time();
                if ($model->validate()){
                    $model->save();
                    return['status'=>1,'msg'=>'订单提交成功'];
                }else{
                    return['status'=>0,'msg'=>$model->getErrors()];
                }
            }else{
                return['status'=>0,'msg'=>'请求方式不对'];
            }
        }
    }
    public function actionGetOrder(){
        if (\Yii::$app->user->isGuest){
            return['status'=>0,'msg'=>'请先登录'];
        }else{
            $member_id=\Yii::$app->user->id;
            $orders=Order::find()->where(['member_id'=>$member_id])->all();
            if ($orders){
                $orders_id=ArrayHelper::map($orders,'id','id');
                $goods=OrderGoods::find()->where(['in','order_id',$orders_id])->all();
                if ($goods){
                    return['status'=>0,'msg'=>$goods];
                }else{
                    return['status'=>0,'msg'=>'没有购买商品'];
                }
            }else{
                return['status'=>0,'msg'=>'没有订单'];
            }
      }
    }
    public function actionDelOrder(){
        if (\Yii::$app->user->isGuest){
            return['status'=>0,'msg'=>'请先登录'];
        }else{
            $member_id=\Yii::$app->user->id;

            $orders=Order::find()->where(['member_id'=>$member_id])->all();
            if ($orders){
                $orders_id=ArrayHelper::map($orders,'id','id');
                //var_dump($orders_id);exit;
                $goods=OrderGoods::deleteAll(['order_id'=>$orders_id]);
                Order::deleteAll(['member_id'=>$member_id]);
                //var_dump($goods);exit;
                //$goods=OrderGoods::find()->where(['in','order_id',$orders_id])->all();
                if ($goods){
                    return['status'=>0,'msg'=>'删除订单成功'];
                }else{
                    return['status'=>0,'msg'=>'没有购买商品'];
                }
            }else{
                return['status'=>0,'msg'=>'没有订单'];
            }
        }
    }
    public function actions()
    {
        return[
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>'3',
                'maxLength'=>'3',
            ],
        ];
    }
    public function actionUpload(){
        $img=UploadedFile::getInstanceByName('img');
        if ($img){
            $filename='/upload/'.uniqid().'.'.$img->extension;
            $data=$img->saveAs(\Yii::getAlias('@webroot').$filename,0);
            if ($data){
                return['status'=>1,'msg'=>$filename];
            }else{
                return['status'=>0,'msg'=>$img->error];
            }
        }else{
           return['status'=>0,'msg'=>'没有文件上传'];
        }
    }
    public function actionList(){
        $per_page=\Yii::$app->request->get('per_page',2);
        $page=\Yii::$app->request->get('page',1);
        $page=$page<1?1:$page;
        $keyword=\Yii::$app->request->get('keyword');
        $query=Goods::find();
        if ($keyword){
            $query->andWhere(['like','name',$keyword]);
        }
        $total=$query->count();
        $data=$query->offset($per_page*($page-1))->limit($per_page)->asArray()->all();
        return['status'=>1,'msg'=>[
            'per_page'=>$per_page,
            'page'=>$page,
            'total'=>$total,
            'data'=>$data
        ]];
    }
    public function actionSendSms(){
        $tel=\Yii::$app->request->post('tel');
        if(!preg_match('/^1[34578]\d{9}$/',$tel)){
            return['status'=>0,'msg'=>'手机号码必须合法'];
        }
        $value=\Yii::$app->cache->get('time_tel_'.$tel);
        $time=time()-$value;
        if ($time<60){
            return['status'=>0,'msg'=>'请在'.(60-$time).'秒后再试'];
        }
        $code=rand(1000,9999);
        $re= \Yii::$app->sms->setNum($tel)->setParam(['code'=>$code])->send();

        if($re){
            //保存当前验证码 session MySQL redis  不能保存在cookie
            \Yii::$app->cache->set('tel_'.$tel,$code,5*60);
            \Yii::$app->cache->set('time_tel_'.$tel,time(),5*60);
           return['status'=>1,'msg'=>'发送成功'];
        }else{
            return['status'=>0,'msg'=>'发送失败'];
        }
    }

}
<?php
namespace frontend\controllers;


use frontend\models\UserForm;
use frontend\models\User;
use yii\web\Controller;
use yii\web\Request;

class UserController extends Controller{
    //使用表单模型创建表单
    public function actionAdd(){
       $user = new User();
       $request= new Request();
        //模型接受表单提交的数据
       if($request->isPost){
           //接受表单提交的数据
           $user->load($request->post());
           //验证数据
           if($user->validate()){
               //保存到数据表

               $user->save();
               //跳转到列表页
               return $this->redirect(['user/index']);
           }else{
               //打印验证失败错误信息
               var_dump($user->getErrors());exit;
           }
       }
        return $this->render('add',['user'=>$user]);
    }
     public function actionIndex(){
         $users=\common\models\User::find()->all();
         return $this->render('index',['users'=>$users]);
     }
    public function actionAddcate(){
        $model=new UserForm();

        return $this->render('addcate',['model'=>$model]);
    }
    public function actions()
    {
        return[
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>4,
                'maxLength'=>4,
            ],
        ];

    }
}

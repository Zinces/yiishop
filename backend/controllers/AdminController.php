<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use backend\models\MpasswordForm;
use yii\filters\AccessControl;
use yii\web\Request;


class AdminController extends \yii\web\Controller
{
    public function actionInit(){
        $admin=new Admin();
        $admin->user='小媳';
        $admin->password='5201314Z';
        $admin->password=\Yii::$app->security->generatePasswordHash($admin->password);
        $admin->email='305977606@qq.com';
        $admin->save();
        return $this->redirect(['admin/login']);
    }
    public function actionIndex()
    {
        $models=Admin::find()->all();
        return $this->render('index',['models'=>$models]);
    }
    public function actionAdd(){
        $model = new Admin();
        $model->setScenario('add');
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->password=\Yii::$app->security->generatePasswordHash($model->password);
                $model->status=1;
                $model->save(false);
                return $this->redirect(['admin/index']); 
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionEdit($id){
        $model =Admin::findOne(['id'=>$id]);
        //$model->scenario=Admin::SCENARIO_EDIT;
        $request=new Request();
        if($request->isPost){
            //var_dump($request->post());exit;
            $model->load($request->post());
            //var_dump($model);exit;
            if($model->validate()){
                //var_dump($model);exit;
                $model->save(false);
                //var_dump($model->getErrors());exit;
                return $this->redirect(['admin/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionDel($id){

       $model=Admin::findOne(['id'=>$id]);
        $model->status=0;
        $model->save(false);
        return $this->redirect(['admin/index']);
    }
    public function actions()
    {
        return[
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>4,
                'maxLength'=>4,
            ]
        ];
    }//验证码
    public function actionLogin(){
        $model=new LoginForm();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                return $this->redirect(['goods/index']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }
    public function actionLogout(){
        $id=\Yii::$app->user->id;

        $model=Admin::findOne(['id'=>$id]);
        $model->end_time=time();
        $model->end_ip=$_SERVER['REMOTE_ADDR'];
        //var_dump($model);exit;
        $model->save(false);
        \Yii::$app->user->logout();
        return $this->redirect(['goods/index']);
    }
    public function actionMpassword(){
        $model=new MpasswordForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
                $model->validatePassword();
                \Yii::$app->user->logout();
                return $this->redirect(['goods/index']);
        }
        return $this->render('mpassword',['model'=>$model]);
    }
/*    public function behaviors()
    {
        return[
            'acf'=>[
                'class'=>AccessControl::className(),
                'only'=>['login','add','index'],//该过滤器作用的操作，默认所有
                'rules'=>[
                    [
                        'allow'=>true,//是否允许执行
                        'actions'=>['login'],//指定操作
                        'roles'=>['?'],//角色？未认证用户，@已认证用户
                    ],
                    [
                        'allow'=>true,//是否允许执行
                        'actions'=>['add','index'],//指定操作
                        'roles'=>['@'],//角色？未认证用户，@已认证用户
//                        'matchCallback'=>function(){
//                            //return \date('j')==5;//几号可以访问
//                        }
                    ],
                    //其他都禁止执行
                ],
            ],
        ];
    }*/


}

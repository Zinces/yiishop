<?php

namespace backend\controllers;

use backend\filters\AccessFilters;
use backend\models\Admin;
use backend\models\LoginForm;
use backend\models\MpasswordForm;
use yii\filters\AccessControl;
use yii\web\Request;


class AdminController extends \yii\web\Controller
{
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
                $id=$model->id;
                $model->addRoles($id);
                return $this->redirect(['admin/index']); 
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionEdit($id){
        $model =Admin::findOne(['id'=>$id]);
        $request=new Request();
        $model->loadData($id);
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                    $model->updateRole($id);
                    $model->save(false);
                    \Yii::$app->session->setFlash('success','修改用户成功');
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
                $model->validatePassword();
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
   public function behaviors()
    {
        return[
            'accessFilters'=>[
                'class'=>AccessFilters::className(),
                'only'=>['index','edit','del']
            ],
        ];
    }



}

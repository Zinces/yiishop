<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
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




}

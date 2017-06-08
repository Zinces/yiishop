<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=Brand::find()->all();
        return $this->render('index',['models'=>$models]);
    }
    public function actionAdd(){
        $model=new  Brand();
        $request=new Request();
        $model->setScenario('add');
        if($request->isPost){
            $model->load($request->post());
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                if($model->imgFile){
                   $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->logo=$fileName;
                }
                $model->save(false);
                \Yii::$app->session->getFlash('success','品牌添加成功');
                return $this->redirect(['brand/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        
        return $this->render('add',['model'=>$model]);
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
    public function actionEdit($id){
        $model=Brand::findOne(['id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                if($model->imgFile){
                    $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->logo=$fileName;
                }
                $model->save(false);
                \Yii::$app->session->getFlash('success','品牌添加成功');
                return $this->redirect(['brand/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }

        return $this->render('add',['model'=>$model]);
    }
    public function actionDel($id){
        $model=Brand::findOne(['id'=>$id]);
        $model->status='-1';
        $model->save();
        return $this->redirect(['brand/index']);
    }
}

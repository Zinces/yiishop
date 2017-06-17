<?php

namespace backend\controllers;

use backend\filters\AccessFilters;
use backend\models\Article_category;
use yii\web\Request;

class Article_categoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=Article_category::find()->all();
        return $this->render('index',['models'=>$models]);
    }
    public function actionAdd(){
        $model=new Article_category();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                return $this->redirect(['article_category/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionEdit($id){
        $model=Article_category::findOne(['id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                return $this->redirect(['article_category/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionDel($id){
        $model=Article_category::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        return $this->redirect(['article_category/index']);
    }
    public function behaviors()
    {
        return[
            'accessFilters'=>[
                'class'=>AccessFilters::className(),
                'only'=>['add','index','edit','del']
            ],
        ];
    }

}

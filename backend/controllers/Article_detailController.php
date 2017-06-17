<?php

namespace backend\controllers;

use backend\filters\AccessFilters;
use backend\models\Article;
use backend\models\Article_detail;
use yii\web\Request;

class Article_detailController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=Article_detail::find()->all();
        return $this->render('index',['models'=>$models]);
    }
    public function actionArticle(){
        $models=Article::find()->all();
        return $this->render('index',['models'=>$models]);
    }
    public function actionAdd(){
        $model=new Article_detail();
        $art=Article::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                $count=[];
                foreach ($art as $a){
                    $count[$a['id']]=$a['name'];
                    return $this->redirect(['article_detail/index']);
                }
            }
        }
        return $this->render('add',['model'=>$model,'art'=>$art]);
    }
    public function actionEdit($id){
        $model=Article_detail::findOne(['id'=>$id]);
        $art=Article::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                $count=[];
                foreach ($art as $a){
                    $count[$a['id']]=$a['name'];
                    return $this->redirect(['article_detail/index']);
                }
            }
        }
        return $this->render('add',['model'=>$model,'art'=>$art]);
    }
    public function actionDel($id){
        $model=Article_detail::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['article_detail/index']);
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

<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\Article_category;
use yii\web\Request;


class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=Article::find()->all();
        return $this->render('index',['models'=>$models]);
    }
    public function actionArticle_category(){
        $models=Article_category::find()->all();
        return $this->render('index',['models'=>$models]);
    }
    public function actionAdd(){
        $model=new Article();
        $art=Article_category::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->create_time=time();
                $model->save();
                $count=[];
                foreach ($art as $a){
                    $count[$a['id']]=$a['name'];
                    return $this->redirect(['article/index']);
                }
            }
        }
        return $this->render('add',['model'=>$model,'art'=>$art]);
    }
    public function actionEdit($id){
        $model=Article::findOne(['id'=>$id]);
        $art=Article_category::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->create_time=time();
                $model->save();
                $count=[];
                foreach ($art as $a){
                    $count[$a['id']]=$a['name'];
                    return $this->redirect(['article/index']);
                }
            }
        }
        return $this->render('add',['model'=>$model,'art'=>$art]);
    }
    public function actionDel($id){
        $model=Article::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        return $this->redirect(['article/index']);
    }

}

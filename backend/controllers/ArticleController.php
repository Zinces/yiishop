<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\Article_category;
use backend\models\Article_detail;
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
        $ar=new Article_detail();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $ar->load($request->post());
            if($model->validate() && $ar->validate()){
                $model->create_time=time();
                $model->save();
                if($model->save()){
                    $ar->article_id=$model->id;
                    $ar->save();
                }

                $count=[];
                foreach ($art as $a){
                    $count[$a['id']]=$a['name'];
                    return $this->redirect(['article/index']);
                }
            }
        }

        return $this->render('add',['model'=>$model,'art'=>$art,'ar'=>$ar]);
    }
    public function actionEdit($id){
        $model=Article::findOne(['id'=>$id]);
        $art=Article_category::find()->all();
        $ar=Article_detail::findOne(['article_id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $ar->load($request->post());
            if($model->validate() && $ar->validate()){
                $model->create_time=time();
                $model->save();
                if($model->save()){
                    $ar->article_id=$model->id;
                    $ar->save();
                }

                $count=[];
                foreach ($art as $a){
                    $count[$a['id']]=$a['name'];
                    return $this->redirect(['article/index']);
                }
            }
        }

        return $this->render('add',['model'=>$model,'art'=>$art,'ar'=>$ar]);
    }
    public function actionDel($id){
        $model=Article::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        return $this->redirect(['article/index']);
    }
    public function actionSel($id){
        $model_article=Article::findOne(['id'=>$id]);
        $model_articledetail=Article_detail::findOne(['article_id'=>$id]);
        return $this->render('select',['model_article'=>$model_article,'model_articledetail'=>$model_articledetail]);
    }

}

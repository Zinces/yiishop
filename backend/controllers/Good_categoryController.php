<?php

namespace backend\controllers;

use backend\models\Goodcategory;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class Good_categoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query=Goodcategory::find();
       /* $total=$query->count();//获取总条数
        $page=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>5,
        ]);*/
        $models=$query->orderBy('tree,lft')->all();
        //$models=$query->offset($page->offset)->limit($page->limit)->orderBy('tree,lft')->all();
        return $this->render('index',['models'=>$models]);
    }
    public function actionAdd(){
        $model=new Goodcategory();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //判断是否是一级分类
            if($model->parent_id){
                  //添加非一级分类
                $parent=Goodcategory::findOne(['id'=>$model->parent_id]);
                $model->prependTo($parent);
            }else{
                //添加一级分类
                $model->makeRoot();
            }
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['good_category/index']);
        }
        //获取所有分类选项
        $options = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],Goodcategory::find()->asArray()->all());

        return $this->render('add',['model'=>$model,'options'=>$options]);
    }
    public function actionEdit($id){
        $model=Goodcategory::findOne(['id'=>$id]);
        if($model == null){
            throw new NotFoundHttpException('分类不存在');
        }
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //判断是否是一级分类
            if($model->parent_id){
                //添加非一级分类
                $parent=Goodcategory::findOne(['id'=>$model->parent_id]);
                $model->prependTo($parent);
            }else{
                //添加一级分类
                if ($model->getOldAttribute('parent_id') == 0){
                    $model->save();
                }else{
                    $model->makeRoot();
                }
            }
            \Yii::$app->session->setFlash('success','修改成功');
            return $this->redirect(['good_category/index']);
        }
        //获取所有分类选项
        $options = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],Goodcategory::find()->asArray()->all());

        return $this->render('add',['model'=>$model,'options'=>$options]);
    }
    
}

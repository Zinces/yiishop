<?php

namespace backend\controllers;

use backend\models\Menu;
use backend\models\PermissionForm;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class MenuController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query=Menu::find();
        $total=$query->count();
        $page=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>10,
        ]);
        $models=$query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['models'=>$models,'page'=>$page]);
    }
    public function actionAdd(){
        $model=new Menu();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','恭喜添加菜单成功');
            return $this->redirect(['menu/index']);
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionEdit($id){
        $model=Menu::findOne(['id'=>$id]);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','恭喜修改菜单成功');
            return $this->redirect(['menu/index']);
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionDel($id){
        $model=Menu::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['menu/index']);
    }
}

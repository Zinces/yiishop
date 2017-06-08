<?php
namespace frontend\controllers;
use frontend\models\Goodclass;
use frontend\models\Goods;
use yii\web\Controller;
use yii\web\Request;

class GoodsController extends Controller{
     public function actionAdd(){
         $model=new Goods();
         $request=new Request();
         if($request->isPost){
             $model->load($request->post());
             if($model->validate()){
                 $model->save();
                 return $this->redirect(['goods/index']);
             }
         }return $this->render('add',['model'=>$model]);
     }
    public function actionIndex(){
        $model=Goods::find()->all();
        return $this->render('index',['model'=>$model]);
    }
    public function actionEdit($id){
        $model=Goods::findOne(['id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                return $this->redirect(['goods/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }return $this->render('add',['model'=>$model]);
    }
    public function actionDel($id){
        $model=Goods::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['goods/index']);
    }


}
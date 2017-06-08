<?php
namespace frontend\controllers;
use frontend\models\Goodclass;
use frontend\models\Goods;
use yii\web\Controller;
use yii\web\Request;

class GoodclassController extends Controller{
      public function actionAdd(){
        $model=new Goodclass();
          $request=new Request();
          if($request->isPost){
          $model->load($request->post());
              if($model->validate()){
                  $model->save();
                  return $this->redirect(['goodclass/index']);
              }else{
                  var_dump($model->getErrors());exit;
              }
          }return $this->render('add',['model'=>$model]);
      }
    public function actionIndex(){
        $model=Goodclass::find()->all();
        return $this->render('index',['model'=>$model]);
    }
    public function actionEdit($id){
        $model=Goodclass::findOne(['id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                return $this->redirect(['goodclass/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }return $this->render('add',['model'=>$model]);
    }
    public function actionDel($id){
        $model=Goodclass::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['goodclass/index']);
    }
    public function actionGoods(){
        $model=Goods::find()->all();
        return $this->render('goods',['model'=>$model]);
    }
}
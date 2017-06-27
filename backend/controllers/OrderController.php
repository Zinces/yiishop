<?php
namespace backend\controllers;
use backend\filters\AccessFilters;
use frontend\models\Order;
use yii\web\Controller;

class OrderController extends Controller{
    public function actionIndex(){
        $models=Order::find()->all();
        return $this->render('index',['models'=>$models]);
    }
    public function actionCreate()
    {
        $id=$_GET['id'];

        $model =Order::findOne(['id'=>$id]);
        //var_dump($model);exit;
        if(\Yii::$app->request->isPost){
            if ($model->load(\Yii::$app->request->post()) && $model->save()) {
                \Yii::$app->session->setFlash('success','操作成功');
            }else{
                //var_dump($model->getErrors());exit;
                \Yii::$app->session->setFlash('error','操作失败');
            }
            return $this->redirect(['index']);
        }else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }
    public function behaviors()
    {
        return[
            'accessFilters'=>[
                'class'=>AccessFilters::className(),
                'only'=>['index','create']
            ],
        ];
    }
}
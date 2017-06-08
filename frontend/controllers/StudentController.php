<?php
namespace frontend\controllers;

use frontend\models\Student;
use yii\web\Controller;
use yii\web\Request;


class StudentController extends Controller{
    public function actionAdd(){
        $model=new Student();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
              if($model->validate()){
                  $model->save();
                  return $this->redirect(['student/index']);
              }else{
                  var_dump($model->getErrors());exit;
              }
        }return $this->render('add',['model'=>$model]);
    }
    public function actionIndex(){
        $model=Student::find()->all();
        return $this->render('index',['model'=>$model]);
    }
    public function actionEdit($id){
        $model=Student::findOne(['id'=>$id]);
        $request=new Request();
        if($request->isPost){
           $model->load($request->post());
            if($model->validate()){
                 $model->save();
                return $this->redirect(['student/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionDel($id){
        $model=Student::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['student/index']);
    }
}
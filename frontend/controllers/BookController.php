<?php
namespace frontend\controllers;
use frontend\models\Book;
use frontend\models\Student;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class BookController extends Controller{

    public function actionAdd(){
        $model=new Book();
        $stu=Student::find()->asArray()->all();
        $request=new Request();
        if($request->isPost){
            //指定数据验证场景
            $model->setScenario('aa');
            $model->load($request->post());
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                $fileName='/images/'.uniqid().'.'.$model->imgFile->extension;
                $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                $model->img=$fileName;
                $model->create_time=time();
                $model->save(false);
                return $this->redirect(['book/index']);
                $count=[];
                foreach($stu as $v){
                    $count[$v['id']]=$v['name'];
                }
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model,'stu'=>$stu]);
    }
    public function actions()
    {
        return[
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>4,
                'maxLength'=>4,
            ],
        ];

    }
    public function actionIndex(){
        $query=Book::find();
        //$model=Book::find()->all();
        $total=$query->count();
        $page=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>2,
        ]);
        $model=$query->offset($page->offset)->limit($page->limit)->all();

        return $this->render('index',['model'=>$model,'page'=>$page]);
    }
    public function actionStudent(){
        $model=Student::find()->all();
        return $this->render('index',['model'=>$model]);
    }
    public function actionEdit($id){
        $model=Book::findOne(['id'=>$id]);
        $stu=Student::find()->asArray()->all();
        $request=new Request();
        if($request->isPost){
           // $model->setScenario('edit');
            $model->load($request->post());
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                if($model->imgFile){
                    $fileName='/images/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->img=$fileName;
                }
                $model->create_time=time();
                $model->save(false);
                return $this->redirect(['book/index']);
                $count=[];
                foreach($stu as $v){
                    $count[$v['id']]=$v['name'];
                }
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model,'stu'=>$stu]);
    }
    public function actionDel($id){
        $model=Book::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['book/index']);
    }

}
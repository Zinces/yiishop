<?php
namespace frontend\controllers;
use Codeception\PHPUnit\Constraint\Page;
use frontend\models\Account;
use frontend\models\LoginForm;
use frontend\models\MpasswordForm;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class AccountController extends Controller{
    public function actionAdd(){
        $model=new Account();
        $model->setScenario('add');
        $request=new Request();
        if($request->isPost) {

            $model->load($request->post());
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            if ($model->validate()) {
                $fileName='/account_img/'.uniqid().'.'.$model->imgFile->extension;
                $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                $model->img=$fileName;
                $model->password=\Yii::$app->security->generatePasswordHash($model->password);
                $model->create_time=time();
                $model->end_time=time();
                $model->save(false);
                //var_dump($model->getErrors());exit;
                return $this->redirect(['account/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionIndex(){
        $query=Account::find();
        //$models=Account::find()->all();
        //$models=$query->all();
        $total=$query->count();
        $page=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>1,
        ]);
        $models=$query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['models'=>$models,'page'=>$page]);
    }
    public function actionEdit($id){
            $model = Account::findOne(['id'=>$id]);
            $request=new Request();
            if($request->isPost) {
                $model->load($request->post());
                $model->imgFile=UploadedFile::getInstance($model,'imgFile');
                if ($model->validate()) {
                    if($model->imgFile){
                        $fileName='/account_img/'.uniqid().'.'.$model->imgFile->extension;
                        $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                        $model->img=$fileName;
                    }
                    $model->save();
                    return $this->redirect(['account/index']);
                }
            }
            return $this->render('add',['model'=>$model]);
        }
    public function actionDel($id){
        $model=Account::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['account/index']);
    }
    public function actionLogin(){
        $model=new LoginForm();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                return $this->redirect(['account/index']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }
    public function actionMpassword(){
        $model=new MpasswordForm();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                $model->validatePassword();
                \Yii::$app->user->logout();
                return $this->redirect(['account/index']);
            }

        }
        return $this->render('mpassword',['model'=>$model]);
    }
    public function behaviors()
    {
        return[
            'acf'=>[
                'class'=>AccessControl::className(),
                'only'=>['add','index','edit','del'],//默认是所有的操作
                'rules'=>[
                    [
                       'allow'=>true,//是否允许执行
                        'actions'=>['index'],//指定操作
                        'roles'=>['?'],//角色？未认证用户，@已认证用户
                    ],
                    [
                        'allow'=>true,//是否允许执行
                        'actions'=>['del','index','add','edit'],//指定操作
                        'roles'=>['@'],//角色？未认证用户，@已认证用户
                    ],
                ],
            ],
        ];
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
}
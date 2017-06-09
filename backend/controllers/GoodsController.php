<?php

namespace backend\controllers;


use xj\uploadify\UploadAction;
use backend\models\Brand;
use backend\models\Goods;
use yii\web\Request;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=Goods::find()->all();
        return $this->render('index',['models'=>$models]);
    }
    public function actionAdd(){
        $model=new Goods();
        $bra=Brand::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->create_time=time();
                $model->save(false);
                $count=[];
                foreach ($bra as $b){
                    $count[$b['id']]=$b['intro'];
                }
                return $this->redirect(['goods/index']);
            }
        }
        return $this->render('add',['model'=>$model,'bra'=>$bra]);
    }
    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                /* 'format' => function (UploadAction $action) {
                     $fileext = $action->uploadfile->getExtension();
                     $filename = sha1_file($action->uploadfile->tempName);
                     return "{$filename}.{$fileext}";
                 },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $imgUrl= $action->getWebUrl();
                    $action->output['fileUrl'] = $action->getWebUrl();
                    //调用七牛云的组件，将图片上传到七牛云
                    $qiniu=\Yii::$app->qiniu;
                    $qiniu->uploadFile(\Yii::getAlias('@webroot').$imgUrl,$imgUrl);
                    //获取图片在七牛云的地址
                    $url = $qiniu->getLink($imgUrl);
                    $action->output['fileUrl']=$url;
                    /* $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                     $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                     $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"*/
                },
            ],
           /* 'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>4,
                'maxLength'=>4,
            ]*/
        ];

    }
    public function actionEdit($id){
        $model=Goods::findOne(['id'=>$id]);
        $bra=Brand::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->create_time=time();
                $model->save(false);
                $count=[];
                foreach ($bra as $b){
                    $count[$b['id']]=$b['intro'];
                }
                return $this->redirect(['goods/index']);
            }
        }
        return $this->render('add',['model'=>$model,'bra'=>$bra]);
    }
    public function actionDel($id){
        $model=Goods::findOne(['id'=>$id]);
        $model->status=0;
        $model->save();
        return $this->redirect(['goods/index']);
    }

}

<?php

namespace backend\controllers;


use backend\components\SphinxClient;
use backend\filters\AccessFilters;
use backend\models\Goodcategory;
use backend\models\Goods_day_count;
use backend\models\Goods_intro;
use backend\models\Goodsgallery;
use backend\models\GoodssearchForm;
use xj\uploadify\UploadAction;
use backend\models\Brand;
use backend\models\Goods;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model=new GoodssearchForm();
        $query=Goods::find();
        if ($keyword=\Yii::$app->request->get('keyword')){

            $cl = new SphinxClient();
            $cl->SetServer ( '127.0.0.1', 9312);
            $cl->SetConnectTimeout ( 10 );
            $cl->SetArrayResult ( true );
            $cl->SetMatchMode ( SPH_MATCH_ALL);
            $cl->SetLimits(0, 1000);
            $res = $cl->Query($keyword, 'goods');//shopstore_search
            //var_dump($res);exit;
            if(!isset($res['matches'])){
                $query->where(['id'=>0]);
            }else{
                //var_dump($res);exit;
                $ids=ArrayHelper::map($res['matches'],'id','id');
                $query->where(['in','id',$ids]);
            }
        }
        //$model->search($query);
        /*$key=isset($_GET['key'])?$_GET['key']:'';
        $query=Goods::find()->andWhere(['like','name',$key]);*/
        $count=$query->count();
        $page=new Pagination([
            'totalCount'=>$count,
            'defaultPageSize'=>2,
        ]);
        $models=$query->offset($page->offset)->limit($page->limit)->all();
        //关键字高亮
        if($keyword !=null) {
            $keywords = array_keys($res['words']);
            $options = array(
                'before_match' => '<span style="color:#ff7534;">',
                'after_match' => '</span>',
                'chunk_separator' => '...',
                'limit' => 80, //如果内容超过80个字符，就使用...隐藏多余的的内容
            );
            foreach ($models as $index => $item) {
                $name = $cl->BuildExcerpts([$item->name], 'goods', implode(',', $keywords), $options); //使用的索引不能写*，关键字可以使用空格、逗号等符号做分隔，放心，sphinx很智能，会给你拆分的
                $models[$index]->name = $name[0];
            }
        }
         return $this->render('index',['models'=>$models,'page'=>$page,'model'=>$model]);

    }
    public function actionGoodcategory()
    {
        $models=Goodcategory::find()->all();
        return $this->render('index',['models'=>$models]);
    }
    public function actionAdd(){
        $model=new Goods();
        $bra=Brand::find()->all();
        $goods=new Goods_intro();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $goods->load($request->post());
            //$goodsday->load($request->post());
            if($model->validate() && $goods->validate()){
               if($goodsday=Goods_day_count::findOne(['day'=>date('Y-m-d')])){
                   $count=($goodsday->count)+1;
                   $model->sn=date('Ymd').str_pad($count,5,'0',STR_PAD_LEFT);
                   $goodsday->count=($goodsday->count)+1;
               }else{
                   $model->sn=date('Ymd').str_pad(1,5,'0',STR_PAD_LEFT);
                   $goodsday=new Goods_day_count();
                   $goodsday->day=date('Y-m-d');
                   $goodsday->count=1;
               }
                $model->create_time=time();
                $model->save(false);
                $goodsday->save();
                if($model){
                    $goods->goods_id=$model->id;
                    $goods->save();

                }
                $count=[];
                foreach ($bra as $b){
                    $count[$b['id']]=$b['intro'];
                }
                return $this->redirect(['goods/index']);
            }
        }
        $options = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],Goodcategory::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'bra'=>$bra,'options'=>$options,'goods'=>$goods]);
    }
    public function actions() {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "",//图片访问路径前缀
                    "imagePathFormat" => "/upload/{yyyy}{mm}{dd}/{time}{rand:6}" ,//上传保存路径
                    "imageRoot" => \Yii::getAlias("@webroot"),
                ],
            ],
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
                    //图片上传成功的同时，将图片和商品关联起来
                    $model = new Goodsgallery();
                    $model->goods_id = \Yii::$app->request->post('goods_id');
                    $model->path = $action->getWebUrl();
                    $model->save();
                    $action->output['fileUrl'] = $model->path;
                    $action->output['goods_id']=$model->id;



                   /*$imgUrl= $action->getWebUrl();
                    $action->output['fileUrl'] = $action->getWebUrl();
                    //调用七牛云的组件，将图片上传到七牛云
                    $qiniu=\Yii::$app->qiniu;
                    $qiniu->uploadFile(\Yii::getAlias('@webroot').$imgUrl,$imgUrl);
                    //获取图片在七牛云的地址
                    $url = $qiniu->getLink($imgUrl);
                    $action->output['fileUrl']=$url;*/

                    $imgUrl= $action->getSavePath();
                    //$action->output['fileUrl'] = $action->getWebUrl();
                    //调用七牛云的组件，将图片上传到七牛云
                    $qiniu=\Yii::$app->qiniu;
                    $qiniu->uploadFile($imgUrl,$imgUrl);
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
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ],
        ];

    }
    public function actionEdit($id){
        $model=Goods::findOne(['id'=>$id]);
        $bra=Brand::find()->all();
        $goods=Goods_intro::findOne(['goods_id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $goods->load($request->post());
            if($model->validate() && $goods->validate()){
                $model->create_time=time();
                $model->save(false);
                if($model){
                    $goods->goods_id=$model->id;
                    $goods->save();
                }
                $count=[];
                foreach ($bra as $b){
                    $count[$b['id']]=$b['intro'];
                }
                return $this->redirect(['goods/index']);
            }
        }
        $options = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],Goodcategory::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'bra'=>$bra,'options'=>$options,'goods'=>$goods]);
    }
    public function actionDel($id){
        $model=Goods::findOne(['id'=>$id]);
        $model->status=0;
        $model->save();
        return $this->redirect(['goods/index']);
    }
    public function actionSel($id){
        $model=Goods_intro::findOne(['goods_id'=>$id]);
        $models=Goods::findOne(['id'=>$id]);
        return $this->render('select',['model'=>$model,'models'=>$models]);
    }
    public function actionGallery($id){
        $goods=Goods::findOne(['id'=>$id]);
        if($goods == null){
            throw new NotFoundHttpException('商品不存在');
        }
        return $this->render('gallery',['goods'=>$goods]);
    }
    public function actionDelgallery(){
          $id=\Yii::$app->request->post('id');
           $model=Goodsgallery::findOne(['id'=>$id]);
        if($model && $model->delete()){
            return 'success';
        }else{
            return 'false';
        }

    }
    public function behaviors()
    {
        return[
            'accessFilters'=>[
                'class'=>AccessFilters::className(),
                'only'=>['add','index','edit','del']
            ],
        ];
    }
    public function actionTest(){
        \Yii::$app->response->format=Response::FORMAT_JSON;
     if ($brand_id=\Yii::$app->request->get('brand_id')){
           $goods=Goods::find()->where(['brand_id'=>$brand_id])->asArray()->all();
           return ['status'=>1,'errormsg'=>'','data'=>$goods];
       }else{
           return ['status'=>0,'errormsg'=>'请求方式不对'];
       }
   }
}

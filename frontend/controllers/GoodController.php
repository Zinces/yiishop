<?php

namespace frontend\controllers;

use backend\components\SphinxClient;
use frontend\models\GoodCategory;
use yii\helpers\ArrayHelper;

class GoodController extends \yii\web\Controller
{
    public $layout='index';
    public function actionIndex()
    {
        $query=\backend\models\Goodcategory::find();
        $models=$query->where(['parent_id'=>0])->all();
          return $this->render('index',['models'=>$models]);
    }

}

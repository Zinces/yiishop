<?php

namespace frontend\controllers;

use frontend\models\GoodCategory;

class GoodController extends \yii\web\Controller
{
    public $layout='index';
    public function actionIndex()
    {
        $models=Goodcategory::findAll(['parent_id'=>0]);
        return $this->render('index',['models'=>$models]);
    }

}

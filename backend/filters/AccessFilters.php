<?php
namespace backend\filters;
use yii\base\ActionFilter;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class AccessFilters extends ActionFilter{
    public function beforeAction($action)
    {
        if(!\Yii::$app->user->can($action->uniqueId)){
            if(\Yii::$app->user->isGuest){
                return $action->controller->redirect(\Yii::$app->user->loginUrl);
            }
            throw new HttpException(403,'不好意思，你没有这个权限');
        }
        return parent::beforeAction($action);
    }

}
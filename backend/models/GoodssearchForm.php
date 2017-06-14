<?php
namespace backend\models;
use yii\base\Model;
use yii\db\ActiveQuery;

class GoodssearchForm extends Model{
     public $name;
     public $sn;
    public $minprice;
    public $maxprice;
    public function rules(){
        return[
            [['name','sn'],'string'],
            [['minprice','maxprice'],'double'],
];
    }
    public function search(ActiveQuery $query){
        $this->load(\Yii::$app->request->get());
        if($this->name){
            $query->andWhere(['like','name',$this->name]);
        }
        if($this->sn){
            $query->andWhere(['like','sn',$this->sn]);
        }
        if($this->minprice){
            $query->andWhere(['>=','shop_price',$this->minprice]);
        }
        if($this->maxprice){
            $query->andWhere(['<=','shop_price',$this->maxprice]);
        }
    }
}
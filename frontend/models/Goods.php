<?php
namespace frontend\models;


use yii\db\ActiveRecord;

class Goods extends  ActiveRecord{
   public function rules(){
       return[
          [['name','sn','detail'],'required'],
           [['price','total'],'integer'],
];
   }
    public function attributeLabels(){
        return[
            'name'=>'商品名称',
            'sn'=>'商品编号',
            'price'=>'商品价格',
            'total'=>'商品库存',
            'detail'=>'商品简介',
];
    }
    public function getGoodclass(){
        return $this->hasOne(Goodclass::className(),['id'=>'goodclass_id']);
    }
}
<?php
namespace frontend\models;
use yii\db\ActiveRecord;

class Goodclass extends ActiveRecord{
        public function rules(){
            return[
                ['name','required'],
];
        }
    public function attributeLabels(){
        return[
            'name'=>'商品分类名'
];
    }

}
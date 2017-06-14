<?php
namespace backend\models;
use yii\db\ActiveRecord;

class Goodsgallery extends ActiveRecord{
    public static function tableName(){
        return 'goods_gallery';
    }
    public function rules(){
       return[
           ['goods_id','integer'],
           ['path','required'],
];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品id',
            'path' => '图片地址',
        ];
    }
}
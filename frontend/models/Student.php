<?php
namespace frontend\models;
use yii\db\ActiveRecord;

class Student extends ActiveRecord{

     public function rules(){
           return[
              [['name','age'],'required'],
];
     }
    public function attributeLabels(){
        return[
        'name'=>'名字',
            'age'=>'年龄',
];
    }
    
}
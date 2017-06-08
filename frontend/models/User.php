<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord{
    public function rules(){
        return[
            //[ 字段名,验证方法]
            [['name','age'],'required'],
            ['age','match','pattern'=>'/^\d{1,3}$/','message'=>'年龄格式不对']
        ];
    }
    public function attributeLabels(){
        //设置属性的标签名称
        return[
            'name'=>'姓名',
            'age'=>'年龄',
        ];
    }
}
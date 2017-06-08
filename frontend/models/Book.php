<?php
namespace frontend\models;
use yii\db\ActiveRecord;

class Book extends ActiveRecord{
    public $imgFile;
    public $code;
    public function getStudent()
    {
        //hasOne的第二个参数【k=>v】 k代表分类的主键（id） v代表商品分类在当前对象的关联id
        return $this->hasOne(Student::className(),['id'=>'student_id']);
    }

    public function rules()
    {
        return[
            [['name','student_id','sn','status','detail'],'required'],
            ['price','integer'],
            ['imgFile','file','extensions'=>['jpg','png','gif'],'skipOnEmpty'=>false,'on'=>['aa']],
            ['code','captcha','captchaAction'=>'user/captcha','on'=>['aa']],
        ];
    }
    public function attributeLabels()
    {
        return[
            'name'=>'书名',
            'price'=>'价格',
            'student_id'=>'作者',
            'sn'=>'编号',
            'status'=>'状态',
            'detail'=>'简介',
            'imgFile'=>'图片',
             'code'=>false,
        ];
    }

}
<?php
namespace frontend\models;
use yii\base\Model;

class UserForm extends Model{
    public $name;
    public $code;
    public function rules()
    {
        return[
            ['name','required'],
            ['code','captcha','captchaAction'=>'user/captcha'],
        ];
    }
    public function attributeLabels()
    {
        return['name'=>'名称',
            'code'=>false,
        ];
    }
}
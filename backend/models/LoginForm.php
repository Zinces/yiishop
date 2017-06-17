<?php
namespace backend\models;
use yii\base\Model;

class LoginForm extends Model{
    public $code;
    public $user;
    public $password;
    public $cookie;
    public function rules()
    {
        return[
            [['user','password'],'required'],
            ['code','captcha','captchaAction'=>'admin/captcha'],
            ['password','validatePassword'],
            ['cookie','safe']
        ];
    }
    public function attributeLabels()
    {
        return[
            'user'=>'用户名',
            'password'=>'密码',
            'code'=>'验证码',
            'cookie'=>'自动登录'
        ];
    }
    public function validatePassword(){
        $admin=Admin::findOne(['user'=>$this->user]);
        if($admin){
                if (!\Yii::$app->security->validatePassword($this->password,$admin->password)){
                    $this->addError('password','密码账号不对');
                }else{
                    $admin->generateAuthKey();
                    $admin->save(false);
                    $cookie=\Yii::$app->user->authTimeout;
                    \Yii::$app->user->login($admin,$this->cookie?$cookie:0);
                    
                    //var_dump($this->cookie);exit;
                }
        }else{
            $this->addError('password','密码账号不对');
        }
    }
}
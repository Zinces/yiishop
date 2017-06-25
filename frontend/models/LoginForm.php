<?php
namespace frontend\models;
use yii\base\Model;

class LoginForm extends Model{
    public $username;
    public $password;
    public $code;
    public $member;
    public function rules()
    {
        return[
            ['username','required'],
            ['password','string','min'=>4,'tooShort'=>'密码过短'],
            ['password','valitaPassword'],
            ['code','captcha','captchaAction'=>'site/captcha'],
            ['member','safe']
        ];
    }
    public function attributeLabels()
    {
        return[
            'username'=>'用户名:',
            'password'=>'密码:',
            'code'=>'验证码:',
            'member'=>'记密码'
        ];
    }
    public function valitaPassword(){
        $admin=Member::findOne(['username'=>$this->username]);
        if($admin){
            if(!\Yii::$app->security->validatePassword($this->password,$admin->password_hash)){
                $this->addError('password','用户名或者密码不正确');
            }else {
                $admin->auth_key=\Yii::$app->security->generateRandomString();
                $admin->last_login_time=time();
                $admin->last_login_ip=ip2long(\Yii::$app->request->getUserIP());
                $admin->save(false);
                \Yii::$app->user->login($admin,$this->member?3600*24*7:0);
            }
        }else{
            $this->addError('password','用户名或者密码不正确');
        }
    }
}
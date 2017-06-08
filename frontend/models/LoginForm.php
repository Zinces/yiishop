<?php
namespace frontend\models;
use yii\base\Model;

class LoginForm extends Model{
    public $username;
    public $password;
    public $code;
    public function rules()
    {
        return [
            [['username','password'],'required'],
            ['password','validateUsername'],
            ['code','captcha','captchaAction'=>'account/captcha']
        ];
        }
    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'code'=>false,
        ];
    }
    public function validateUsername(){
        $account=Account::findOne(['username'=>$this->username]);

        if($account){
            if(!\Yii::$app->security->validatePassword($this->password,$account->password)){
                $this->addError('password','账号或密码不正确');
            }else{
                $account->end_time=time();
                $account->save();
                \Yii::$app->user->login($account);

            }
        }else{
            $this->addError('password','账号或密码不正确');
        }
    }
}
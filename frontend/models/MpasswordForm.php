<?php
namespace frontend\models;
use yii\base\Model;

class MpasswordForm extends Model
{

    public $password;
    public $repassword;
    public $old_password;
    public $code;

    public function rules()
    {
        return [
            [[ 'password', 'old_password', 'repassword'], 'required'],
            [['password', 'repassword'], 'string', 'min' => 6],
            ['repassword', 'validatePassword'],
            ['code','captcha','captchaAction'=>'account/captcha'],
            ['repassword','compare','compareAttribute'=>'password','message'=>'两次新密码不一致'],
        ];
    }

    public function attributeLabels()
    {
        return [

            'old_password' => '旧密码',
            'password' => '新密码',
            'repassword' => '再输新密码',
            'code'=>false,
        ];
    }

    public function validatePassword()
    {
        $id=\Yii::$app->user->id;
        $account=Account::findOne(['id'=>$id]);
        if(\Yii::$app->security->validatePassword($this->old_password,$account->password)){
            if($this->repassword ==$this->password){
                $newpassword=\Yii::$app->security->generatePasswordHash($this->password);
                $account->password=$newpassword;
                $account->save();
            }else{
                $this->addError('repassword','两次新密码不一致');
            }
        }else{
            $this->addError('repassword','旧密码不正确');
        }
    }

}
<?php
namespace backend\models;
use yii\base\Model;

class MpasswordForm extends Model{
    public $old_password;
    public $password;
    public $repassword;
    public $code;
    public function rules()
    {
        return[
            [['old_password','password','repassword'],'required'],
            [['password','repassword'],'string','min'=>4,'message'=>'密码长度不够'],
            ['code','captcha','captchaAction'=>'admin/captcha'],
            ['repassword','compare','compareAttribute'=>'password','message'=>'两次新密码不一致'],
            ['repassword','validatePassword'],
        ];
    }
    public function attributeLabels()
    {
        return[
            'old_password'=>'旧密码',
            'password'=>'新密码',
            'repassword'=>'再输新密码',
            'code'=>'验证码'
        ];
    }
    public function validatePassword(){
        $id=\Yii::$app->user->id;
        //var_dump($id);exit;
        $admin=Admin::findOne(['id'=>$id]);
        if(\Yii::$app->security->validatePassword($this->old_password,$admin->password)){
            if($this->password == $this->repassword){
                //echo 1;exit;
                $newpassword=\Yii::$app->security->generatePasswordHash($this->password);
                $admin->password=$newpassword;
                //var_dump($admin);exit;
                $admin->save(false);
                //var_dump($admin->getErrors());exit;
                }else{
                var_dump($admin->getErrors());exit;
            }
             }else{
            $this->addError('old_password','账号密码不正确');
        }
    }

}
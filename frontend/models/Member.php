<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $tel
 * @property integer $last_login_time
 * @property integer $last_login_ip
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public $password;
    public $newpassword;
    public $code;
    public $sms;
    public function rules()
    {
        return [
            [['username'], 'required','message'=>'用户名不能为空'],
            [['password_hash','sms'],'safe'],
            [['last_login_time', 'last_login_ip', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'email'], 'string', 'max' => 100],
            [['tel'], 'string', 'max' => 11],
            ['newpassword','compare','compareAttribute'=>'password','message'=>'再输一次密码'],
            ['email', 'email','message'=>'邮箱必须合法'],
            [['password','newpassword'],'string','length'=>[4,32],'tooShort'=>'密码过短'],
            [['tel'],'match','pattern'=>'/^[1][358][0-9]{9}$/','message'=>'手机号码必须合法'],
           ['code','captcha','captchaAction'=>'site/captcha'],
            ['sms','validateSms']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名:',
            'auth_key' => '自动登陆验证码',
            'password_hash' => '密码',
            'email' => '邮箱:',
            'tel' => '手机号码:',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录IP',
            'status' => '状态',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
            'password'=>'密码:',
            'newpassword'=>'确认密码:',
            'code'=>'验证码:',
            'sms'=>'手机验证:'
        ];
    }
    //验证短信验证码
    public function validateSms(){
        $code=Yii::$app->cache->get('tel_'.$this->tel);
        if(!$code||$this->sms != $code){
            $this->addError('sms','验证码不正确');
        }
    }
    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() ==$authKey;
    }
}

<?php

namespace backend\models;

use Codeception\Module\Redis;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $user
 * @property string $password
 * @property integer $end_time
 * @property string $end_ip
 */
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    //定义场景字段
    //const SCENARIO_ADD='add';
    //const SCENARIO_EDIT='edit';
    /* public function scenarios()
    *{
         $scenarios=parent::scenarios();
         $scenarios[self::SCENARIO_ADD]=['password','repassword'];
         $scenarios[self::SCENARIO_EDIT]=['password','repassword'];
         return $scenarios;
     }*/

    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     *
     */
    public $code;
    public $repassword;
    public $roles=[];
    static public $statusOptisn=[0=>'失效',1=>'正常'];
    public static function getRole(){
        $authmanager=Yii::$app->authManager->getRoles();
        return ArrayHelper::map($authmanager,'name','description');
    }
    public function addRoles($id){
        $authmanager=Yii::$app->authManager;
        foreach ($this->roles as $roleName){
            $role=$authmanager->getRole($roleName);
            if($role){
                $authmanager->assign($role,$id);
            }
        }
        return true;
    }
    public function loadData($id){
        foreach (Yii::$app->authManager->getRolesByUser($id) as $role){
            $this->roles[]=$role->name;
        }
    }
    public function updateRole($id){
         $authmanager=Yii::$app->authManager;
         $authmanager->revokeAll($id);
         foreach ($this->roles as $roleName){
            $role=$authmanager->getRole($roleName);
            if($role){
                $authmanager->assign($role,$id);
            }
        }
        return true;
    }
    public function rules()
    {
        return [
            [['user', 'password'], 'required','on'=>['add']],
            [['end_time','status'], 'integer'],
            [['user', 'end_ip','email'], 'string', 'max' => 255,'on'=>['add']],
            ['code','captcha','captchaAction'=>'admin/captcha'],
            [['password','repassword'],'string','min'=>4,'tooShort'=>'密码太短','on'=>['add']],
            ['repassword','compare','compareAttribute'=>'password','message'=>'两次新密码不一致','on'=>['add']],
            [['end_time','end_ip'], 'string', 'max' => 255,'on'=>['add']],
            ['email','unique','message'=>'邮箱存在','on'=>['add']],
            ['email','match','pattern'=>'/\w+([-.]\w+)*@(qq|163|126)\.com/','message'=>'邮箱格式不对','on'=>['add']],
            ['roles','safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => '用户名',
            'password' => '密码',
            'end_time' => '最后登录时间',
            'end_ip' => '最后登录ip',
            'code'=>false,
            'repassword'=>'再输一次密码',
            'email'=>'邮箱',
            'roles'=>'角色',
        ];
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
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */

    ////1
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() == $authKey;
    }
    /**
     * @inheritdoc
     */
    //2
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    /**
     * Generates "remember me" authentication key
     */
    //3.
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

}

<?php
namespace backend\models;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model{
    public $name;
    public $description;
    public $permissions=[];
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            ['permissions','safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'角色名称',
            'description'=>'角色描述',
            'permissions'=>'权限',
        ];
    }
    public static function getPermissions(){

        return ArrayHelper::map(\Yii::$app->authManager->getPermissions(),'name','description');
    }
    public function addRole(){
         $authmanager=\Yii::$app->authManager;
        if($authmanager->getRole($this->name)){
            $this->addError('name','角色存在');
        }else{
            $role=$authmanager->createRole($this->name);
            $role->description=$this->description;
            if($authmanager->add($role)){
                foreach ($this->permissions as $permissionName){
                    $permission=$authmanager->getPermission($permissionName);
                    if($permission){
                        $authmanager->addChild($role,$permission);
                    }
                }
                return true;
            }
        }
            return false;
    }
    public function loadData($role){
        $this->name=$role->name;
        $this->description=$role->description;
        foreach (\Yii::$app->authManager->getPermissionsByRole($role->name) as $permission){
            $this->permissions[]=$permission->name;
        }
    }
    public function updateRole($name){
        $authmanager=\Yii::$app->authManager;
        $role=$authmanager->getRole($name);
        if($name != $this->name && $authmanager->getRole($this->name)){
            $this->addError('name','角色存在');
        }else{
            //先删除角色拥有的所有权限
            $authmanager->removeChildren($role);
            $role=$authmanager->createRole($this->name);
            $role->description=$this->description;
            if($authmanager->update($name,$role)){
                foreach ($this->permissions as $permissionName){
                    $permission=$authmanager->getPermission($permissionName);
                    if($permission){
                        $authmanager->addChild($role,$permission);
                    }
                }
            }
            return true;
        }
        return false;
    }
}
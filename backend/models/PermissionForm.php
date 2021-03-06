<?php
namespace backend\models;
use yii\base\Model;

class PermissionForm extends Model{
    public $name;
    public $description;
    public function rules()
    {
        return [
            [['name','description'],'required'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'权限名称',
            'description'=>'权限描述',
        ];
    }
    public function addPermission(){
        $authManager=\Yii::$app->authManager;
        if($authManager->getPermission($this->name)){
            $this->addError('name','权限已存在');
        }else{
            $permission=$authManager->createPermission($this->name);
            $permission->description=$this->description;
            return $authManager->add($permission);
        }
        return false;
    }
    public function loadData($permission){
        $this->name=$permission->name;
        $this->description=$permission->description;
    }
    public function updatePermission($name){
        $authmanager=\Yii::$app->authManager;
        $permission=$authmanager->getPermission($name);
        if($name !=$this->name && $authmanager->getPermission($this->name)){
            $this->addError('name','权限存在');
        }else{
            $permission=$authmanager->createPermission($name);
            $permission->description=$this->description;
            return $authmanager->update($name,$permission);
        }
        return false;
    }
}
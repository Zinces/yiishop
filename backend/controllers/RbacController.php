<?php
namespace backend\controllers;
use backend\filters\AccessFilters;
use backend\models\PermissionForm;
use backend\models\RoleForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RbacController extends Controller{
    public function actionAddpermission(){
        $model =new PermissionForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->addPermission()){
                \Yii::$app->session->setFlash('success','权限添加成功');
                return $this->redirect(['rbac/indexpermission']);
            };
        }
        return $this->render('addpermission',['model'=>$model]);
    }
    public function actionIndexpermission(){
        $models=\Yii::$app->authManager->getPermissions();
        return $this->render('indexpermission',['models'=>$models]);
    }
    public function actionEditpermission($name){
        $permission=\Yii::$app->authManager->getPermission($name);
        if($permission == null){
            throw new NotFoundHttpException('权限不存在');
        }

        $model=new PermissionForm();
        $model->loadData($permission);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if ($model->updatePermission($name)){
                \Yii::$app->session->setFlash('success','权限修改成功');
                return $this->redirect(['rbac/indexpermission']);
            }
        }
        return $this->render('addpermission',['model'=>$model]);
    }
    public function actionDelpermission($name){
        $permission=\Yii::$app->authManager->getPermission($name);
        if($permission == null){
            throw new NotFoundHttpException('权限不存在');
        }
        \Yii::$app->authManager->remove($permission);
        \Yii::$app->session->setFlash('success','权限删除成功');
        return $this->redirect(['rbac/indexpermission']);

    }
    public function actionAddrole(){
        $model =new RoleForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if ($model->addRole()){
                \Yii::$app->session->setFlash('success','添加角色成功');
                return $this->redirect(['rbac/indexrole']);
            }
        }
        return $this->render('addrole',['model'=>$model]);
    }
    public function actionIndexrole(){
        $models=\Yii::$app->authManager->getRoles();
        return $this->render('indexrole',['models'=>$models]);
    }
    public function actionEditrole($name){
        $role=\Yii::$app->authManager->getRole($name);
        if($role == null){
            throw new NotFoundHttpException('角色不存在');
        }
        $model=new RoleForm();
        //回显修改数据
        $model->loadData($role);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->updateRole($name)){
                \Yii::$app->session->setFlash('success','角色修改成功');
                return $this->redirect(['rbac/indexrole']);
            }
        }
        return $this->render('addrole',['model'=>$model]);
    }
    public function actionDelrole($name){
        $role=\Yii::$app->authManager->getRole($name);
        if($role == null){
            throw new NotFoundHttpException('角色不存在');
        }
        \Yii::$app->authManager->remove($role);
        \Yii::$app->session->setFlash('success','删除角色成功');
        return $this->redirect(['rbac/indexrole']);
    }
   public function behaviors()
    {
        return[
            'accessFilters'=>[
                'class'=>AccessFilters::className(),
                'only'=>['Addpermission','indexpermission','editpermission','delpermission','addrole','editrole','indexrole','delrole']
            ],
        ];
    }
}
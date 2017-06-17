<table class="table table-condensed table-bordered table-hover">
    <tr>
        <th>角色名称</th>
        <th>角色描述</th>
        <th>关联权限</th>
        <th>角色操作</th>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->description?></td>
            <td><?php
                foreach (Yii::$app->authManager->getPermissionsByRole($model->name) as $permission){
                    echo $permission->description;
                    echo ' | ';
                }
                ?></td>
            <td><?=\yii\bootstrap\Html::a('修改',['rbac/editrole','name'=>$model->name],['class'=>'btn btn-warning btn-xs'])?> <?=\yii\bootstrap\Html::a('删除',['rbac/delrole','name'=>$model->name],['class'=>'btn btn-danger btn-xs'])?></td>
        </tr>
    <?php endforeach;?>
</table>
<table class="table table-condensed table-hover">
    <tr>
        <th>权限名称</th>
        <th>权限描述</th>
        <th>权限操作</th>
    </tr>
    <?Php foreach ($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->description?></td>
            <td><?php if(Yii::$app->user->can('rbac/editpermission')){echo \yii\bootstrap\Html::a('修改',['rbac/editpermission','name'=>$model->name],['class'=>'btn btn-warning btn-xs']);}?> <?php if(Yii::$app->user->can('rbac/delpermission')){echo \yii\bootstrap\Html::a('删除',['rbac/delpermission','name'=>$model->name],['class'=>'btn btn-danger btn-xs']);}?></td>
        </tr>
    <?php endforeach;?>
</table>
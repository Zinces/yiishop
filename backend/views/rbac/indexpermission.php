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
            <td><?=\yii\bootstrap\Html::a('修改',['rbac/editpermission','name'=>$model->name],['class'=>'btn btn-warning bnt-xs'])?> <?=\yii\bootstrap\Html::a('删除',['rbac/delpermission','name'=>$model->name],['class'=>'btn btn-danger bnt-xs'])?></td>
        </tr>
    <?php endforeach;?>
</table>
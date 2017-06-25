<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>权限名称</th>
        <th>权限描述</th>
        <th>权限操作</th>
    </tr>
    </thead>
    <tbody>
    <?Php foreach ($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->description?></td>
            <td><?php if(Yii::$app->user->can('rbac/editpermission')){echo \yii\bootstrap\Html::a('修改',['rbac/editpermission','name'=>$model->name],['class'=>'btn btn-warning btn-xs']);}?> <?php if(Yii::$app->user->can('rbac/delpermission')){echo \yii\bootstrap\Html::a('删除',['rbac/delpermission','name'=>$model->name],['class'=>'btn btn-danger btn-xs']);}?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot>
    <tr>
        <th>权限名称</th>
        <th>权限描述</th>
        <th>权限操作</th>
    </tr>
    </tfoot>
</table>
<?php

$this->registerCssFile('@web/css/jquery.dataTables.min.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$js=<<<JS
$(document).ready(function() {
    $('#example').DataTable();
} );
JS;
$this->registerJs($js);
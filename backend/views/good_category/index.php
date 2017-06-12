<table class="table table-hover ">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>父类名称</th>
        <th>节点操作</th>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>

        <td><?=$model->id?></td>
        <td><?=str_repeat('_',$model->depth).$model->name?>
        <td><?=$model->parent_id?$model->parent->name:''?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['good_category/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?></td>
    </tr>
    <?php endforeach;?>
</table>
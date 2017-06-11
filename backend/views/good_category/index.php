<table class="table table-hover ">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>节点操作</th>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>

        <td><?=$model->id?></td>
        <td><?=str_repeat('-',$model->depth).$model->name?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['good_category/edit','id'=>$model->id],['class'=>'btn btn-primary btn-xs'])?></td>
    </tr>
    <?php endforeach;?>
</table>
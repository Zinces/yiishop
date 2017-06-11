<table class="table table-hover ">
    <tr>
        <th>节点</th>
        <th>所属父节点</th>
        <th>节点简介</th>
        <th>节点操作</th>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>
        <td><?=$model->name?></td>
        <td><?=$model->parent_id?></td>
        <td><?=$model->intro?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['good_category/edit','id'=>$model->id],['class'=>'btn btn-primary btn-xs'])?></td>
    </tr>
    <?php endforeach;?>
</table>
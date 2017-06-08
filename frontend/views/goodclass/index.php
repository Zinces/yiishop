<table class="table table-hover table-bordered">
    <tr>
        <th>id</th>
        <th>商品分类名</th>
        <th>商品分类操作</th>
    </tr>
     <?php foreach($model as $models):?>
        <tr>
            <td><?=$models->id?></td>
            <td><?=$models->name?></td>
            <td><?=\yii\bootstrap\Html::a('修改',['goodclass/edit','id'=>$models->id],['class'=>'btn btn-warning btn-xs'])?> <?=\yii\bootstrap\Html::a('删除',['goodclass/del','id'=>$models->id],['class'=>'btn btn-danger btn-xs'])?></td>
        </tr>

    <?php endforeach;?>
</table>
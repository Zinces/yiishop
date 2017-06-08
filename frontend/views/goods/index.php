<table class="table table-bordered table-hover">
    <tr>
        <th>id</th>
        <th>商品名称</th>
        <th>商品编号</th>
        <th>商品价格</th>
        <th>商品库存</th>
        <th>商品分类</th>
        <th>商品简介</th>
        <th>商品操作</th>
    </tr>
    <?php foreach($model as $models):?>
        <tr>
            <td><?=$models->id?></td>
            <td><?=$models->name?></td>
            <td><?=$models->sn?></td>
            <td><?=$models->price?></td>
            <td><?=$models->total?></td>
            <td><?=$models->total?></td>
            <td><?=$models->detail?></td>
            <td><?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$models->id],['class'=>'btn btn-warning btn-xs'])?> <?=\yii\bootstrap\Html::a('删除',['goods/del','id'=>$models->id],['class'=>'btn btn-danger btn-xs'])?></td>
        </tr>
     <?php endforeach;?>
</table>
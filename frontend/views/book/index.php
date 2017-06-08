<table class="table table-hover">
    <tr>
        <th>id</th>
        <th>书名</th>
        <th>作者</th>
        <th>价格</th>
        <th>编号</th>
        <th>创建时间</th>
        <th>状态</th>
        <th>描述</th>
        <th>LOGO</th>
        <th>操作</th>
    </tr>
    <?php foreach ($model as $models):?>
        <tr>
            <td><?=$models->id?></td>
            <td><?=$models->name?></td>
            <td><?=$models->student->name?></td>
            <td><?=$models->price?></td>
            <td><?=$models->sn?></td>
            <td><?=date('Y-m-d H:i:s',$models->create_time);?></td>
            <td><?=($models->status)?'架':'下架';?></td>
            <td><?=$models->detail?></td>
            <td><img src="<?=$models->img?>" width="40px" height="30px"></td>
            <td><?=\yii\bootstrap\Html::a('修改',['book/edit','id'=>$models->id],['class'=>'btn btn-warning btn-xs'])?> <?=\yii\bootstrap\Html::a('删除',['book/del','id'=>$models->id],['class'=>'btn btn-warning btn-xs'])?></td>
        </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);

?>
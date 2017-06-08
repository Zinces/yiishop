<table class="table table-hover table-bordered">
    <tr>
        <th>id</th>
        <th>姓名</th>
        <th>年龄</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $models):?>
        <tr>
            <td><?=$models->id?></td>
            <td><?=$models->name?></td>
            <td><?=$models->age?></td>
            <td><?=\yii\bootstrap\Html::a('修改',['student/edit','id'=>$models->id],['class'=>'btn btn-warning btn-xs'])?> <?=\yii\bootstrap\Html::a('删除',['student/del','id'=>$models->id],['class'=>'btn btn-danger btn-xs'])?></td>
        </tr>
    <?php endforeach;?>
</table>
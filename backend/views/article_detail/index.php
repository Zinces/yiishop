<table class="table table-hover table-bordered">
    <tr>
        <th>文章名称</th>
        <th>文章名详情</th>
        <th>文章名操作</th>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->article->name?></td>
            <td><?=$model->content?></td>
            <td><?=\yii\bootstrap\Html::a('修改',['article_detail/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?> <?=\yii\bootstrap\Html::a('删除',['article_detail/del','id'=>$model->id],['class'=>'btn btn-danger btn-xs'])?></td>
        </tr>
    <?php endforeach;?>
</table>
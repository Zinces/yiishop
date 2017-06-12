<table class="table table-hover">
    <tr>
        <th>文章分类名</th>
        <th>文章分类简介</th>
        <th>文章分类排序</th>
        <th>文章分类状态</th>
        <th>文章分类类型</th>
        <th>文章分类操作</th>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->intro?></td>
            <td><?=$model->sort?></td>
            <td><?=\backend\models\Article_category::$statusOptions[$model->status]?></td>
            <td><?=\backend\models\Article_category::$is_helpOptions[$model->is_help]?></td>
            <td><?=\yii\bootstrap\Html::a('修改',['article_category/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?> <?=\yii\bootstrap\Html::a('删除',['article_category/del','id'=>$model->id],['class'=>'btn btn-danger btn-xs'])?></td>
        </tr>
    <?php endforeach;?>
</table>


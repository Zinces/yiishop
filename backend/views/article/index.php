<table class="table table-hover">
    <tr>
        <th>文章名称</th>
        <th>文章简介</th>
        <th>文章分类</th>
        <th>文章排序</th>
        <th>文章状态</th>
        <th>文章创建时间</th>
        <th>文章操作</th>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->intro?></td>
            <td><?=$model->article_category->name?></td>
            <td><?=$model->sort?></td>
            <td><?=\backend\models\Article::$statusOptions[$model->status]?></td>
            <td><?=date('Y-m-d H:i:s',$model->create_time)?></td>
            <td><?=\yii\bootstrap\Html::a('查看',['article/sel','id'=>$model->id],['class'=>'btn btn-primary btn-xs'])?> <?php if(Yii::$app->user->can('article/edit')){
                    echo \yii\bootstrap\Html::a('修改',['article/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs']);
                }?> <?php if(Yii::$app->user->can('article/del')){
                    echo \yii\bootstrap\Html::a('删除',['article/del','id'=>$model->id],['class'=>'btn btn-danger btn-xs']);
                }?></td>
        </tr>
    <?php endforeach;?>
</table>

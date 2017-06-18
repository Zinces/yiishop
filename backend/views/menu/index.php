<table class="table table-bordered table-responsive table-hover">
    <tr>
        <th>菜单名称</th>
        <th>菜单路由</th>
        <th>菜单父菜单</th>
        <th>菜单操作  <?=\yii\bootstrap\Html::a('添加菜单',['menu/add'],['class'=>'btn btn-primary btn-xs'])?></th>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->label?></td>
            <td><?=$model->url?></td>
            <td><?=$model->parent_id?$model->parent->label:'顶级菜单'?></td>
            <td><?php if(Yii::$app->user->can('menu/edit')){
                    echo \yii\bootstrap\Html::a('修改',['menu/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs']);
                }?> <?php if(Yii::$app->user->can('menu/del')){
                    echo \yii\bootstrap\Html::a('删除',['menu/del','id'=>$model->id],['class'=>'btn btn-danger btn-xs']);
                }?></td>
        </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);
<table class="table table-hover tab-content">
    <tr>
        <th>品牌名称</th>
        <th>品牌简介</th>
        <th>品牌LOGO</th>
        <th>品牌排序</th>
        <th>品牌状态</th>
        <th>品牌操作</th>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->intro?></td>
            <td><?=\yii\bootstrap\Html::img($model->logo,['width'=>30,'height=>30'])?></td>
            <td><?=$model->sort?></td>
            <td><?=\backend\models\Brand::$statusOptions[$model->status]?></td>
            <td><?php if(Yii::$app->user->can('brand/edit')){
                    echo \yii\bootstrap\Html::a('修改',['brand/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs']);
                }?> <?php if(Yii::$app->user->can('brand/del')){
                    echo \yii\bootstrap\Html::a('删除',['brand/del','id'=>$model->id],['class'=>'btn btn-danger btn-xs']);
                }?></td>
        </tr>
    <?php endforeach;?>
</table>

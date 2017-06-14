<div class="text-center">
<?php
/*echo \yii\bootstrap\Html::beginForm(['goods/index'],'get');
echo \yii\bootstrap\Html::textInput('name');
echo \yii\bootstrap\Html::textInput('sn');
echo \yii\bootstrap\Html::submitInput('搜索',['class'=>'btn btn-info btn-xs']);
echo \yii\bootstrap\Html::endForm();*/
$form=\yii\bootstrap\ActiveForm::begin(['method'=>'get','action'=>\yii\helpers\Url::to(['goods/index']),'options'=>['class'=>'form-inline']]);
echo $form->field($model,'name')->textInput(['placeholder'=>'商品名称'])->label(false);
echo $form->field($model,'sn')->textInput(['placeholder'=>'货号'])->label(false);
echo $form->field($model,'minprice')->textInput(['placeholder'=>'￥'])->label(false);
echo $form->field($model,'maxprice')->textInput(['placeholder'=>'￥'])->label('—');
echo \yii\bootstrap\Html::submitInput('搜索',['class'=>'btn btn-info','style'=>'position:absolute']);
\yii\bootstrap\ActiveForm::end();
?>
</div>
<table class="table table-hover table-bordered tab-content">
    <tr>
        <th>商品名称</th>
        <th>商品货号</th>
        <th>商品LOGO</th>
        <th>商品分类id</th>
        <th>商品品牌</th>
        <th>市场价格</th>
        <th>商品价格</th>
        <th>商品库存</th>
        <th>是否在售</th>
        <th>状态</th>

        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->sn?></td>
            <td><?=\yii\bootstrap\Html::img($model->logo ,['height'=>30])?></td>
            <td><?=$model->good_category->name?></td>
            <td><?=$model->brand->intro?></td>
            <td><?=$model->market_price?></td>
            <td><?=$model->shop_price?></td>
            <td><?=$model->stock?></td>
            <td><?=\backend\models\Goods::$is_on_saleOptions[$model->is_on_sale]?></td>
            <td><?=\backend\models\Goods::$statusOptions[$model->status]?></td>

            <td><?=date('Y-m-d H:i:s',$model->create_time)?></td>
            <td><?=\yii\bootstrap\Html::a('相册',['goods/gallery','id'=>$model->id],['class'=>'bnt btn-warning btn-xs'])?><?=\yii\bootstrap\Html::a('查看',['goods/sel','id'=>$model->id],['class'=>'bnt btn-primary btn-xs'])?><?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$model->id],['class'=>'bnt btn-warning btn-xs'])?><?=\yii\bootstrap\Html::a('删除',['goods/del','id'=>$model->id],['class'=>'bnt btn-danger btn-xs'])?></td>
        </tr>
    <?php endforeach;?>
</table>
<div class="text-center">
<?php
echo \yii\widgets\LinkPager::widget([
   'pagination'=>$page,
    'firstPageLabel'=>'首页',
    'prevPageLabel'=>'上一页',
    'nextPageLabel'=>'下一页',
    'lastPageLabel'=>'末尾'
]);


?>
</div>
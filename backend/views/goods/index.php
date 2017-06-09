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
        <th>排序</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->sn?></td>
            <td><?=\yii\bootstrap\Html::img($model->logo ,['height'=>30])?></td>
            <td><?=$model->good_category_id?></td>
            <td><?=$model->brand->intro?></td>
            <td><?=$model->market_price?></td>
            <td><?=$model->shop_price?></td>
            <td><?=$model->stock?></td>
            <td><?=\backend\models\Goods::$is_on_saleOptions[$model->is_on_sale]?></td>
            <td><?=\backend\models\Goods::$statusOptions[$model->status]?></td>
            <td><?=$model->sort?></td>
            <td><?=date('Y-m-d H:i:s',$model->create_time)?></td>
            <td><?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$model->id],['class'=>'bnt btn-warning btn-xs'])?> <?=\yii\bootstrap\Html::a('删除',['goods/del','id'=>$model->id],['class'=>'bnt btn-danger btn-xs'])?></td>
        </tr>
    <?php endforeach;?>
</table>
<table class="table table-hover table-bordered tab-content">
    <tr>
        <th>姓名</th>
        <th>地址</th>
        <th>电话号码</th>
        <th>快递方式</th>
        <th>快递价格</th>
        <th>支付方式</th>
        <th>订单状态</th>
        <th>总金额</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->province.$model->city.$model->area.$model->address?></td>
            <td><?=$model->tel?></td>
            <td><?=$model->delivery_name?></td>
            <td><?=$model->delivery_price?></td>
            <td><?=$model->payment_name?></td>
            <td><?=\frontend\models\Order::$statusOptions[$model->status]?></td>
            <td><?=$model->total?></td>
            <td><?=date('Y-m-d H:i:s',$model->create_time)?></td>
            <td><?php echo \yii\bootstrap\Html::a('修改', '#', [
                'id' => 'create',
                'data-toggle' => 'modal',
                'data-target' => '#create-modal',
                'class' => 'btn btn-success btn-xs update',
                'data-id'=>$model->id,
                ]);?></td>
        </tr>
    <?php endforeach;?>
</table>
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'create-modal',
    'header' => '<h4 class="modal-title">修改</h4>',
    //'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
]);
$requestUrl = \yii\helpers\Url::to(['order/create']);
$js = <<<JS
$(".update").on('click',function() {
    var id =  $(this).attr('data-id');
    $.get('{$requestUrl}',{"id":id},function (data) {
           $('.modal-body').html(data);
         }  
    );
});
  
JS;
$this->registerJs($js);
\yii\bootstrap\Modal::end();

?>
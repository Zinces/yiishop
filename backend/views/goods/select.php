<table class="table table-bordered table-hover">
    <tr>
        <th>商品名称</th>

    </tr>
    <tr>
        <td><?=$models->name?></td>

    </tr>
</table>
<table class="table table-bordered table-hover">
    <tr>

        <th>商品详情</th>
    </tr>
    <tr>

        <td><?=$model->content?></td>
    </tr>
</table>
<?=\yii\bootstrap\Html::a('首页',['goods/index'],['class'=>'btn btn-warning center-block '])?>
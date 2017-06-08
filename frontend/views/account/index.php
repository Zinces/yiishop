<table class="table table-hover">
    <tr>
        <th>用户名</th>
    
        <th>性别</th>
        <th>LOGO</th>
        <th>创建时间</th>
        <th>最后登录时间</th>
        <th>账号状态</th>
        <th>账号操作</th>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->username?></td>

           <!-- <td><?/*=($model->sex)?'女':'男'*/?></td>-->
            <td><?=\frontend\models\Account::$sexOptions[$model->sex]?></td>
            <!--<td><img src="<?/*=$model->img*/?>" width="30" height="30"></td>-->
            <td><?=\yii\bootstrap\Html::img($model->img,['width'=>30,'height'=>30])?></td>
            <td><?=date('Y-m-d H-i-s',$model->create_time)?></td>
            <td><?=date('Y-m-d H-i-s',$model->end_time)?></td>
            <td><?=\frontend\models\Account::$statusOptions[$model->status]?></td>
            <td><?=\yii\bootstrap\Html::a('修改',['account/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?> <?=\yii\bootstrap\Html::a('删除',['account/del','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?></td>
        </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);
?>
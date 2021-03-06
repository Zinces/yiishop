<table class="table table-hover table-bordered">
    <tr>
        <th>用户名</th>
        <th>关联角色</th>
        <th>用户邮箱</th>
        <th>最后登录时间</th>
        <th>最后登录IP</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>
        <td><?=$model->user?></td>
        <td><?php
            foreach (Yii::$app->authManager->getRolesByUser($model->id) as $role){
                echo $role->description;
                echo ' | ';
            }
            ?></td>
        <td><?=$model->email?></td>
        <td><?=date('Y-m-d H:i:s',$model->end_time)?></td>
        <td><?=$model->end_ip?></td>
        <td><?=\backend\models\Admin::$statusOptisn[$model->status]?></td>
        <td><?php if(Yii::$app->user->can('admin/edit')){
                echo \yii\bootstrap\Html::a('修改',['admin/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs']);
            }?> <?php if(Yii::$app->user->can('admin/del')){
                echo \yii\bootstrap\Html::a('删除',['admin/del','id'=>$model->id],['class'=>'btn btn-danger btn-xs']);
            }?></td>
    </tr>
    <?php endforeach;?>
</table>

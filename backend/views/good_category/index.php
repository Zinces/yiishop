<table class="cate table table-hover ">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>父类名称</th>
        <th>节点操作</th>
    </tr>
    <?php foreach ($models as $model):?>
    <tr data-lft="<?=$model->lft?>" data-rgt="<?=$model->rgt?>" data-tree="<?=$model->tree?>">
        <td><?=$model->id?></td>
        <td><?=str_repeat('—',$model->depth).$model->name?>
        <td><?=$model->parent_id?$model->parent->name:''?>
        <span class="toggle_cate glyphicon glyphicon-chevron-down" style="float: right"></span></td>
        <td><?=\yii\bootstrap\Html::a('修改',['good_category/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?></td>
    </tr>
    <?php endforeach;?>
</table>
<?php
$js=<<<js
  $('.toggle_cate').click(function () {
        var tr=$(this).closest('tr');
        var tree=parseInt(tr.attr('data-tree'));
        var lft=parseInt(tr.attr('data-lft'));
        var rgt=parseInt(tr.attr('data-rgt'));
        //显示还是隐藏图标
        var show=$(this).hasClass('glyphicon-chevron-up');
        //切换图片
        $(this).toggleClass('glyphicon-chevron-up');
        $(this).toggleClass('glyphicon-chevron-down');
            $('.cate tr').each(function () {
                if(parseInt($(this).attr('data-tree'))==tree && parseInt($(this).attr('data-lft'))>lft && parseInt($(this).attr('data-rgt'))<rgt )
                    show?$(this).fadeIn():$(this).fadeOut();
            })
    })
js;
$this->registerJs($js);
?>


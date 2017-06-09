<table class="table table-bordered table-hover">
    <tr>
        <th>文章标题</th>

    </tr>
    <tr>
        <td><?=$model_article->name?></td>

    </tr>
</table>
<table class="table table-bordered table-hover">
    <tr>

        <th>文章内容</th>
    </tr>
    <tr>

        <td><?=$model_articledetail->content?></td>
    </tr>
</table>
<?=\yii\bootstrap\Html::a('首页',['article/index'],['class'=>'btn btn-warning center-block '])?>
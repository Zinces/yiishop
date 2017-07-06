<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>WeUI</title>
    <!-- 引入 WeUI -->
    <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
</head>
<body>
<!-- 使用 -->
<div class="weui-cells__title">订单列表</div>

<div class="weui-cells weui-cells_form">
    <?php foreach ($models as $model):?>
        <div class="weui-cell">
            <input class="weui-input" type="text" value="<?=$model->goods_name;?>">
            <input class="weui-input" type="text" value="￥<?=$model->total;?>">
        </div>
    <?php endforeach;?>
    </div>

</div>

</body>
</html>

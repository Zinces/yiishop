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
<div class="weui-cells__title">收货地址</div>

<div class="weui-cells weui-cells_form">
    <?php foreach ($models as $model):?>
        <div class="weui-cell">
             <div class="weui-cell__bd">
                <input class="weui-input" type="text" value="<?=$model->name;?>">
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" value="<?=$model->tel;?>">
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" value="<?=$model->province_id;?><?=$model->city_id;?><?=$model->district_id;?><?=$model->address;?>">
            </div>
         </div>
    <?php endforeach;?>
    </div>

</div>

</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>收货地址</title>



</head>
<body>


<div style="clear:both;"></div>

<!-- 页面主体 start -->
<div class="main w1210 bc mt10">
    <div class="crumb w1210">
        <h2><strong>我的XX </strong><span>> 我的订单</span></h2>
    </div>

    <!-- 左侧导航菜单 start -->
    <div class="menu fl">
        <h3>我的XX</h3>
        <div class="menu_wrap">
            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="<?=\yii\helpers\Url::to(['address/orindex'])?>">我的订单</a></dd>
                <dd><b>.</b><a href="">我的关注</a></dd>
                <dd><b>.</b><a href="">浏览历史</a></dd>
                <dd><b>.</b><a href="">我的团购</a></dd>
            </dl>

            <dl>
                <dt>账户中心 <b></b></dt>
                <dd class="cur"><b>.</b><a href="">账户信息</a></dd>
                <dd><b>.</b><a href="">账户余额</a></dd>
                <dd><b>.</b><a href="">消费记录</a></dd>
                <dd><b>.</b><a href="">我的积分</a></dd>
                <dd><b>.</b><a href="">收货地址</a></dd>
            </dl>

            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">返修/退换货</a></dd>
                <dd><b>.</b><a href="">取消订单记录</a></dd>
                <dd><b>.</b><a href="">我的投诉</a></dd>
            </dl>
        </div>
    </div>
    <!-- 左侧导航菜单 end -->

    <!-- 右侧内容区域 start -->
    <div class="content fl ml10">
        <div class="address_hd">
            <h3>收货地址薄</h3>
            <?php foreach ($models as $model1):?>
            <dl>

                <dt><?=$model1->id?>.<?=$model1->name?> <?=$model1->location->name?> <?=$model1->location1->name?> <?=$model1->location2->name?> <?=$model1->address?> <?=$model1->tel?></dt>
                <dd>
                    <?=\yii\bootstrap\Html::a('修改',['address/edit','id'=>$model1->id])?>
                    <?=\yii\bootstrap\Html::a('删除',['address/del','id'=>$model1->id])?>
                    <?=\yii\bootstrap\Html::a(\frontend\models\Address::$statusOptions[$model1->status],['address/she','id'=>$model1->id])?>
                </dd>
            </dl>
            <?php endforeach;?>

        </div>

        <div class="address_bd mt10">
            <h4>新增收货地址</h4>
            <?php
            $url=\yii\helpers\Url::toRoute(['get-region']);
                $form=\yii\widgets\ActiveForm::begin([
                    'fieldConfig'=>['options'=>['tag'=>'li'],
                        'errorOptions'=>['tag'=>'p']]
                ]);
                echo '<ul>';
                echo $form->field($model,'name')->textInput(['class'=>'txt']);
                //echo $form->field($model,'area')->textInput(['class'=>'txt']);
                echo $form->field($model, 'province')->widget(\chenkby\region\Region::className(),[
                'model'=>$model,
                'url'=>$url,
                'province'=>[
                    'attribute'=>'province',
                    'items'=>\frontend\models\Locations::getRegion(),
                    'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择省份']
                ],
                'city'=>[
                    'attribute'=>'city',
                    'items'=>\frontend\models\Locations::getRegion($model['province']),
                    'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择城市']
                ],
                'district'=>[
                    'attribute'=>'district',
                    'items'=>\frontend\models\Locations::getRegion($model['city']),
                    'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择县/区']
                ]
            ]);
                echo $form->field($model,'address')->textInput(['class'=>'txt']);
                echo $form->field($model,'tel')->textInput(['class'=>'txt']);
                echo $form->field($model,'status')->checkbox()->label('　');
                echo '<br/>'.'<br/>';
                echo '<li>
								<label for="">&nbsp;</label>
								<input type="submit" name="" class="btn" value="保存">
							</li>';
                echo '</ul>';
                \yii\widgets\ActiveForm::end();
            ?>

        </div>

    </div>
    <!-- 右侧内容区域 end -->
</div>
<!-- 页面主体 end-->


</body>
</html>
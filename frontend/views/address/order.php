
<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li>您好，欢迎来到京西！[
                    <?php
                    if(Yii::$app->user->isGuest){
                        echo  '您好，请'.\yii\helpers\Html::a('登录',['member/login']);
                    }else{
                        echo \yii\helpers\Html::a('注销',['member/logout']).  Yii::$app->user->identity->username;
                    }
                    ?>
                    ]  </li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->


<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="/images/logo.png" alt="京西商城"></a></h2>
        <div class="flow fr flow2">
            <ul>
                <li>1.我的购物车</li>
                <li class="cur">2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>
<?php $form=\yii\widgets\ActiveForm::begin();?>
<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>

    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息</h3>
            <div class="address_info">
             <?php foreach ($address as $addres):?>
               <p>

                   <input type="radio" value="<?=$addres->id?>" name="address_id" <?=$addres->id==5?'checked="checked"':''?>/><?=$addres->name.' '.$addres->tel.' '.$addres->location->name.' '.$addres->location1->name.' '.$addres->location2->name.' '.$addres->address?></p>
               <?php endforeach;?>
            </div>


        </div>
        <!-- 收货人信息  end-->

        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 </h3>


            <div class="delivery_select">
                <table>
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (\frontend\models\Order::$sendway as $id=>$delivery):?>
                    <tr <?=$id==1?'class="cur"':''?>>
                        <td>
                            <input type="radio" name="delivery" class="delivery1"  value="<?=$id?>"/><?=$delivery['delivery_name']?>
                        </td>
                        <td><?=$delivery['delivery_price']?></td>
                        <td><?=$delivery['delivery_intro']?></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>

            </div>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 </h3>


            <div class="pay_select">
                <table>
                    <?php foreach (\frontend\models\Order::$payway as $id=>$payment):?>
                    <tr <?=$id==1?'class="cur"':''?>>
                        <td class="col1"><input type="radio" name="payment" value="<?=$id?>" <?=$id==1?'checked="checked"':''?>/><?=$payment['payment_name']?></td>
                        <td class="col2"><?=$payment['payment_intro']?></td>
                    </tr>

                    <?php endforeach;?>
                </table>

            </div>
        </div>
        <!-- 支付方式  end-->

        <!-- 发票信息 start-->
        <div class="receipt none">
            <h3>发票信息 </h3>


            <div class="receipt_select ">
                <form action="">
                    <ul>
                        <li>
                            <label for="">发票抬头：</label>
                            <input type="radio" name="type" checked="checked" class="personal" />个人
                            <input type="radio" name="type" class="company"/>单位
                            <input type="text" class="txt company_input" disabled="disabled" />
                        </li>
                        <li>
                            <label for="">发票内容：</label>
                            <input type="radio" name="content" checked="checked" />明细
                            <input type="radio" name="content" />办公用品
                            <input type="radio" name="content" />体育休闲
                            <input type="radio" name="content" />耗材
                        </li>
                    </ul>
                </form>

            </div>
        </div>
        <!-- 发票信息 end-->

        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($carts as $cart):?>
                <tr>
                    <td class="col1"><a href=""><?=\yii\helpers\Html::img($cart->goods->logo)?></a>  <strong><a href=""><?=$cart->goods->name?></a></strong></td>
                    <td class="col3">￥<?=$cart->goods->shop_price?></td>
                    <td class="col4"><?=$cart->amount?></td>
                    <td class="col5"><span>￥<?=$cart->goods->shop_price*$cart->amount?></span></td>
                </tr>
               <?php endforeach;?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span><?=count($carts)?> 件商品，总商品金额：</span>
                                <em>￥<?php $zong=0;foreach ($carts as $cart) {
                                        $price = ($cart->goods->shop_price) * ($cart->amount);
                                        $zong+=$price;
                                    }

                                    echo $zong;
                                    ?></em>
                            </li>
                            <!--<li>
                                <span>返现：</span>
                                <em>-￥240.00</em>
                            </li>-->
                            <li>
                                <span>运费：</span>
                                <em>￥<span class="yunfei">0</span></em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em>￥<span class="jinge"><?=$zong+0?></span></em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">
        <?=\yii\helpers\Html::submitButton('提交订单')?>
        <p>应付总额：￥<strong class="zongjinge"><?=$zong+0?></strong>元</p>
        <input type="hidden" name="total" value="" id="zongjiage">
    </div>
</div>
<!-- 主体部分 end -->
<?php \yii\widgets\ActiveForm::end();?>
<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/images/xin.png" alt="" /></a>
        <a href=""><img src="/images/kexin.jpg" alt="" /></a>
        <a href=""><img src="/images/police.jpg" alt="" /></a>
        <a href=""><img src="/images/beian.gif" alt="" /></a>
    </p>
</div>
<!-- 底部版权 end -->
<?php
/* @var $this \yii\web\View*/
$this->registerJs(new \yii\web\JsExpression(
        <<<JS
    $(".delivery1").click(function() {
        var price=$(this).closest('tr').find('td:eq(1)').html();
        $(".yunfei").html(price);
        var yun=$("input[name='delivery']:checked").closest('tr').find('td:eq(1)').html();
        var you=parseInt(yun);
        var zongjinge=you+{$zong};
        //console.log(parseInt(yun.substring(1,yun.length)));
        $(".jinge").html(zongjinge);
        $(".zongjinge").html(zongjinge);
        $("#zongjiage").val(zongjinge);
        
  })
    
JS

))

?>


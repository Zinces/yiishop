<?php
use yii\helpers\Html;
?>
<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $form=\yii\widgets\ActiveForm::begin([
                    'fieldConfig'=>['options'=>['tag'=>'li'],
                        'errorOptions'=>['tag'=>'p']
                        ]
            ]);
            echo '<ul>';
            echo $form->field($model,'username')->textInput(['class'=>'txt']);
            echo $form->field($model,'password')->passwordInput(['class'=>'txt']);
            echo $form->field($model,'newpassword')->passwordInput(['class'=>'txt']);
            echo $form->field($model,'email')->textInput(['class'=>'txt']);
            echo $form->field($model,'tel')->textInput(['class'=>'txt']);
            $button=Html::button('发送手机验证码',['id'=>'send_sms','class'=>'btn btn-success']);
            echo $form->field($model,'sms',['options'=>['class'=>'checkcode '],'template' => "{label}\n{input}$button\n{hint}\n{error}"])->textInput(['class'=>'txt']);
            echo $form->field($model,'code',['options'=>['class'=>'checkcode ']])->widget(\yii\captcha\Captcha::className(),['template'=>'{input}{image}']);
            echo '<label for="">&nbsp;</label><input type="submit" value="" class="login_btn">';
            echo '</ul>';
            \yii\widgets\ActiveForm::end();
            ?>
        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->
<?php
/* @var $this \yii\web\View
*/
$url=\yii\helpers\Url::to(['member/sendsms']);
$this->registerJs(new \yii\web\JsExpression(
        <<<JS
    $("#send_sms").click(function() {
            //启用输入框
        var time=60,msg ='',that=$(this);
	        var interval = setInterval(function(){
			    console.log(1);
				time--;
				if(time<=0){
					clearInterval(interval);
					msg = '获取验证码';
					that.prop('disabled',false);
				} else{
					msg = time+'秒后再次获取';
				    that.prop('disabled',true);
				}
				that.text(msg);
			},1000)
          //发送验证码按钮被点击时
          //手机号码
          var tel=$("#member-tel").val();
          $.post('$url',{tel:tel},function(data) {
            if(data == 'success'){
                 console.log('发送成功');   
			}else{
                console.log(data);
			}
          });
        })
JS

))

?>
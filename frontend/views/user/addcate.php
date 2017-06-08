<?php
$from=\yii\widgets\ActiveForm::begin();
echo $from->field($model,'name')->textInput();
echo $from->field($model,'code')->widget(\yii\captcha\Captcha::className(),['captchaAction'=>'user/captcha','template'=>'<div class="row"><div class="col-lg-1">{image}</div><div class="col-lg-2">{input}</div></div>']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\widgets\ActiveForm::end();
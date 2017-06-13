<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'user');
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),['captchaAction'=>'admin/captcha']);
echo $form->field($model,'cookie')->radio();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

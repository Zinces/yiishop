<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'user');
if ($model->isNewRecord){
    echo $form->field($model,'password')->passwordInput();
    echo $form->field($model,'repassword')->passwordInput();
}else{
    echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Admin::$statusOptisn);
}

echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),['captchaAction'=>'admin/captcha']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'imgFile')->fileInput();
if (!$model->isNewRecord){
    echo \yii\bootstrap\Html::img($model->logo,['width'=>30,'height'=>30]);
}
echo $form->field($model,'sort');
echo $form->field($model,'status',['inline'=>true])->radioList([0=>'隐藏',1=>'正常']);

if ($model->isNewRecord){
    echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),['captchaAction'=>'brand/captcha']);
}
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
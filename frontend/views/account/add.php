<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username')->textInput();
if ($model->isNewRecord) {
    echo $form->field($model,'password')->passwordInput();
}
echo $form->field($model,'sex',['inline'=>true])->radioList(\frontend\models\Account::$sexOptions);
echo $form->field($model,'imgFile')->fileInput();
if(!$model->isNewRecord){
    echo \yii\bootstrap\Html::img($model->img,['width'=>30,'height'=>30]);
}
/*echo $form->field($model,'status')->dropDownList([0=>'冻结',1=>'正常']);*/
echo $form->field($model,'status',['inline'=>true])->radioList(\frontend\models\Account::$statusOptions);
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),['captchaAction'=>'account/captcha']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
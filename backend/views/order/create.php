<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'status')->dropDownList(\frontend\models\Order::$statusOptions);
echo \yii\bootstrap\Html::submitButton('提交',['btn btn-info']);
\yii\bootstrap\ActiveForm::end();
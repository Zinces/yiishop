<?php
$a=\yii\widgets\ActiveForm::begin();
echo $a->field($model,'name')->textInput();
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
\yii\widgets\ActiveForm::end();
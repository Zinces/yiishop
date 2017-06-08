<?php
$from=\yii\widgets\ActiveForm::begin();
echo $from->field($model,'name')->textInput();
echo $from->field($model,'sn')->textInput();
echo $from->field($model,'price')->textInput();
echo $from->field($model,'total')->textInput();
echo $from->field($model,'detail')->textarea();
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
\yii\widgets\ActiveForm::end();
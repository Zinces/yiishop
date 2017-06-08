<?php

$from=\yii\widgets\ActiveForm::begin();
echo $from->field($model,'name')->textInput();
echo $from->field($model,'age')->textInput();
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
\yii\widgets\ActiveForm::end();
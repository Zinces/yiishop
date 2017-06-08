<?php
//使用表单组件创建表单
$from = \yii\widgets\ActiveForm::begin();  //表单开始
echo $from->field($user,'name')->textInput();
echo $from->field($user,'age')->textInput();
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
\yii\widgets\ActiveForm::end();    //表单结束

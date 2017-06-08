<?php
$from=\yii\bootstrap\ActiveForm::begin();
echo $from->field($model,'name')->textInput();
//下拉框选择作者传值；
//echo $from->field($model,'student_id')->dropDownList([1=>'男',2=>'女']);
echo $from->field($model,'student_id')->dropDownList(\yii\helpers\ArrayHelper::map($stu,'id','name'));
echo $from->field($model,'price')->textInput();
echo $from->field($model,'sn')->textInput();
//echo $from->field($model,'status')->dropDownList([0=>'上架',1=>'下架']);
echo $from->field($model,'status',['inline'=>true])->radioList([1=>'上架',0=>'下架']);
echo $from->field($model,'detail')->textInput();
echo $from->field($model,'imgFile')->fileInput();

if($model->isNewRecord){
    echo $from->field($model,'code')->widget(\yii\captcha\Captcha::className(),['captchaAction'=>'user/captcha','template'=>'<div class="row"><div class="col-lg-1">{image}</div><div class="col-lg-2">{input}</div></div>']);
}else{
    echo \yii\bootstrap\Html::img($model->img,['width'=>'50','height'=>'30']);
}
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
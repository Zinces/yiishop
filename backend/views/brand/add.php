<?php
use yii\web\JsExpression;
use xj\uploadify\Uploadify;

$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();

echo $form->field($model,'logo')->hiddenInput();
echo \yii\bootstrap\Html::fileInput('test', null, ['id' => 'test']);
echo Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        //将上传成功后的图片地址（data.fileUrl).show();
        $("#img_logo").attr("src",data.fileUrl).show();
        //将上传成功后的图片地址(data.fileUrl)写入logo；
        $("#brand-logo").val(data.fileUrl);
       }
}
EOF
        ),
    ]
]);
if($model->logo){
    echo \yii\helpers\Html::img($model->logo,['id'=>'img_logo','height'=>40]);
}else{
    echo \yii\helpers\Html::img('',['style'=>'display:none','id'=>'img_logo','height'=>40]);
}

echo $form->field($model,'sort');
echo $form->field($model,'status',['inline'=>true])->radioList([0=>'隐藏',1=>'正常']);

if ($model->isNewRecord){
    echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),['captchaAction'=>'brand/captcha']);
}
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
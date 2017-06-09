<?php
use yii\web\JsExpression;
use xj\uploadify\Uploadify;
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
//echo $form->field($model,'logo');
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
        $("#goods-logo").val(data.fileUrl);
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

echo $form->field($model,'good_category_id');
echo $form->field($model,'brand_id')->dropDownList(\yii\helpers\ArrayHelper::map($bra,'id','intro'));
echo $form->field($model,'market_price');
echo $form->field($model,'shop_price');
echo $form->field($model,'stock');
echo $form->field($model,'is_on_sale',['inline'=>true])->radioList([1=>'在售',0=>'下架']);
echo $form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'回收站']);
echo $form->field($model,'sort');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
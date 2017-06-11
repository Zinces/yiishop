<?php
use \kucha\ueditor\UEditor;
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'article_category_id')->dropDownList(\backend\models\Article::getArticle_categorys(),['prompt'=>'请选择分类']);
//echo $form->field($ar,'content')->textarea( );
echo $form->field($ar,'content')->widget('kucha\ueditor\UEditor',[]);
echo $form->field($model,'sort');
echo $form->field($model,'status',['inline'=>true])->radioList([0=>'隐藏',1=>'正常']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
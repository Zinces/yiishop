<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $status
 */
class Brand extends \yii\db\ActiveRecord
{
    //public $imgFile;
    public $code;
    static public $statusOptions=[-1=>'删除',0=>'隐藏',1=>'正常'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['intro'], 'string'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255],
           // ['imgFile','file','extensions'=>['gif','png','jpg'],'on'=>['add']],
            ['code','captcha','captchaAction'=>'brand/captcha','on'=>['add']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名牌名称',
            'intro' => '名牌简介',
            'logo' => '名牌LOGO',
            'sort' => '名牌排序',
            'status' => '名牌状态',
            //'imgFile'=>'logo',
            'code'=>false,
        ];
    }
}

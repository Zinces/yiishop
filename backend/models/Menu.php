<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $label
 * @property string $url
 * @property integer $parent_id
 * @property integer $sort
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }
    public static function getMenu(){
        return  ArrayHelper::merge(['0'=>'顶级菜单'],ArrayHelper::map(self::find()->where(['parent_id'=>0])->asArray()->all(),'id','label'));
    }
    public function getParent(){
        return $this->hasOne(self::className(),['id'=>'parent_id']);
    }
    public function getParents(){
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label'], 'required'],
            [[ 'sort'], 'integer'],
            [['label','parent_id'], 'string', 'max' => 20],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => '菜单',
            'url' => '地址路由',
            'parent_id' => '父菜单id',
            'sort' => '排序',
        ];
    }
}

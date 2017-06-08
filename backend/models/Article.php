<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $article_category_id
 * @property integer $sort
 * @property integer $status
 * @property integer $create_time
 */
class Article extends \yii\db\ActiveRecord
{
    static public $statusOptions=[-1=>'删除',0=>'隐藏',1=>'正常'];
    public function getArticle_category(){
        return $this->hasOne(Article_category::className(),['id'=>'article_category_id']);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['intro'], 'string'],
            [['article_category_id', 'sort', 'status', 'create_time'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章内容',
            'intro' => '文章简介',
            'article_category_id' => '分类ID',
            'sort' => '文章排序',
            'status' => '文章状态',
            'create_time' => '文章创建时间',
        ];
    }
}

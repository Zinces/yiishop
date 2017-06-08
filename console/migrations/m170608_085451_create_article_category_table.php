<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m170608_085451_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('文章名称'),
            'intro'=>$this->text()->comment('文章简介'),
            'sort'=>$this->integer()->comment('文章排序'),
            'status'=>$this->smallInteger(2)->comment('文章状态'),
            'is_help'=>$this->smallInteger(2)->comment('文章类型'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}

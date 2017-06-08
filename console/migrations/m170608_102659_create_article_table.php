<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m170608_102659_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('文章内容'),
            'intro'=>$this->text()->comment('文章简介'),
            'article_category_id'=>$this->integer()->comment('分类ID'),
            'sort'=>$this->integer()->comment('文章排序'),
            'status'=>$this->smallInteger(3)->comment('文章状态'),
            'create_time'=>$this->integer()->comment('文章创建时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}

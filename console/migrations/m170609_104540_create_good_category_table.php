<?php

use yii\db\Migration;

/**
 * Handles the creation of table `good_category`.
 */
class m170609_104540_create_good_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('good_category', [
            'id' => $this->primaryKey(),
            'tree'=>$this->integer()->comment('树id'),
            'lft'=>$this->integer()->comment('左值'),
            'rgt'=>$this->integer()->comment('右值'),
            'depth'=>$this->integer()->comment('层级'),
            'name'=>$this->string(50)->comment('名称'),
            'parent_id'=>$this->integer()->comment('上级分类id'),
            'intro'=>$this->text()->comment('简介'),
            
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('good_category');
    }
}

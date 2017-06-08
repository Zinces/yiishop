<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m170608_071623_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('名牌名称'),
            'intro'=>$this->text()->comment('名牌简介'),
            'logo'=>$this->string(255)->comment('名牌LOGO'),
            'sort'=>$this->integer()->comment('名牌排序'),
            'status'=>$this->smallInteger(2)->comment('名牌状态'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}

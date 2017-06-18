<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170618_025244_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'label'=>$this->string(20)->notNull()->comment('菜单'),
            'url'=>$this->string(255)->comment('地址'),
            'parent_id'=>$this->string(255)->comment('父菜单id'),
            'sort'=>$this->integer()->comment('排序'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}

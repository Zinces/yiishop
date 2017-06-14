<?php

use yii\db\Migration;

/**
 * Handles the creation of table `album`.
 */
class m170614_030304_create_album_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('album', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer()->comment('商品名称'),
            'path'=>$this->string(255)->comment('图片路径')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('album');
    }
}

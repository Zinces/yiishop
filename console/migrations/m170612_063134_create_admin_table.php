<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170612_063134_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'user'=>$this->string(255)->notNull()->comment('用户名'),
            'password'=>$this->string(255)->notNull()->comment('密码'),
            'end_time'=>$this->integer()->comment('最后登录时间'),
            'end_ip'=>$this->string(255)->comment('最后登录ip'),
            'status'=>$this->smallInteger(2)->comment('账号状态')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}

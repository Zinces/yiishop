<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170615_044148_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'user'=>$this->string(255)->notNull(),
            'auth_key'=>$this->string(32),
            'password'=>$this->string(255),
            'password_reset_token'=>$this->string(255),
            'email'=>$this->string(255),
            'end_time'=>$this->integer(),
            'end_ip'=>$this->string(255),
            'status'=>$this->smallInteger(2),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer(),
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

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m170619_031320_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(50)->notNull()->comment('用户名:'),
            'auth_key'=>$this->string(32)->comment('自动登陆验证码'),
            'password_hash'=>$this->string(100)->notNull()->comment('密码'),
            'email'=>$this->string(100)->comment('邮箱'),
            'tel'=>$this->char(11)->comment('手机号码'),
            'last_login_time'=>$this->integer()->comment('最后登录时间'),
            'last_login_ip'=>$this->integer()->comment('最后登录IP'),
            'status'=>$this->smallInteger(1)->comment('状态'),
            'created_at'=>$this->integer()->comment('添加时间'),
            'updated_at'=>$this->integer()->comment('修改时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}

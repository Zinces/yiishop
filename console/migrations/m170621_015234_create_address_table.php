<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m170621_015234_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(20)->notNull()->comment('收货人'),
            'user_id'=>$this->integer(),

            'address'=>$this->string(255)->comment('详细地址'),
            'tel'=>$this->char(11)->comment('手机号码'),
            'status'=>$this->smallInteger(1)->comment('默认地址'),
            'province_id'=>$this->integer(),
            'city_id'=>$this->integer(),
            'district_id'=>$this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}

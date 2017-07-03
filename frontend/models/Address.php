<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $name
 * @property string $area
 * @property string $address
 * @property string $tel
 * @property integer $status
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public $province;
    public $city;
    public $district;
    static public $statusOptions=[0=>'设置默认地址',1=>'默认地址'];
    public function rules()
    {
        return [
            [['name','tel','address',], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 11],
            [['province','city','district'],'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '* 收货人:',
            'province' => '* 所在地区:',
            'address' => '* 详细地址:',
            'tel' => '* 手机号码:',
            'status' => '默认地址',

        ];
    }
    public function getLocation(){
        return $this->hasOne(Locations::className(),['id'=>'province_id']);
    }
    public function getLocation1(){
        return $this->hasOne(Locations::className(),['id'=>'city_id']);
    }
    public function getLocation2(){
        return $this->hasOne(Locations::className(),['id'=>'district_id']);
    }



}

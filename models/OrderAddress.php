<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_address".
 *
 * @property string $id
 * @property integer $order_id
 * @property integer $address_type
 * @property string $contact_person
 * @property string $address_1
 * @property string $address_2
 * @property integer $city
 * @property integer $state
 * @property integer $country
 * @property string $postcode
 * @property string $contact_no
 *
 * @property Cities $city0
 * @property Countries $country0
 * @property Order $order
 * @property States $state0
 */
class OrderAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'contact_person', 'address_1', 'address_2', 'city', 'state', 'country', 'postcode'], 'required'],
            [['order_id', 'address_type', 'city', 'state', 'country'], 'integer'],
            [['contact_person', 'address_1', 'address_2', 'postcode', 'contact_no'], 'string', 'max' => 255],
            [['city'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city' => 'id']],
            [['country'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['country' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['state'], 'exist', 'skipOnError' => true, 'targetClass' => States::className(), 'targetAttribute' => ['state' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'address_type' => 'Address Type',
            'contact_person' => 'Contact Person',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'postcode' => 'Postcode',
            'contact_no' => 'Contact No',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity0()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry0()
    {
        return $this->hasOne(Countries::className(), ['id' => 'country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState0()
    {
        return $this->hasOne(States::className(), ['id' => 'state']);
    }
}

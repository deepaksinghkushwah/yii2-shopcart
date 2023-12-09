<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shipping_address".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $contact_person
 * @property string $address_line1
 * @property string $address_line2
 * @property integer $city
 * @property integer $state
 * @property integer $postcode
 * @property integer $country
 * @property string $contact_no
 *
 * @property Cities $city0
 * @property Countries $country0
 * @property States $state0
 * @property User $user
 */
class ShippingAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shipping_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'contact_person', 'address_line1', 'city', 'state', 'postcode', 'country'], 'required'],
            [['user_id', 'city', 'state', 'postcode', 'country'], 'integer'],
            [['contact_person', 'address_line1', 'address_line2', 'contact_no'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'contact_person' => Yii::t('app', 'Contact Person'),
            'address_line1' => Yii::t('app', 'Address Line1'),
            'address_line2' => Yii::t('app', 'Address Line2'),
            'city' => Yii::t('app', 'City'),
            'state' => Yii::t('app', 'State'),
            'postcode' => Yii::t('app', 'Postcode'),
            'country' => Yii::t('app', 'Country'),
            'contact_no' => Yii::t('app', 'Contact No'),
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
    public function getState0()
    {
        return $this->hasOne(States::className(), ['id' => 'state']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property integer $id
 * @property string $name
 * @property integer $state_id
 *
 * @property ShippingAddress[] $shippingAddresses
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'state_id'], 'required'],
            [['state_id'], 'integer'],
            [['name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'state_id' => Yii::t('app', 'State ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShippingAddresses()
    {
        return $this->hasMany(ShippingAddress::className(), ['city' => 'id']);
    }
}

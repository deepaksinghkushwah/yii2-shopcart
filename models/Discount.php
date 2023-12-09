<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "discount".
 *
 * @property int $id
 * @property string $title
 * @property string $discount_code
 * @property int $discount_type 1 = flat, 2 = percent, 3 = free shipping
 * @property double $discount_value
 * @property string $expire_date
 * @property string $created_at
 * @property int $status 0 = inactive, 1 = active
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discount';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['discount_code','unique'],
            [['title', 'discount_code'], 'required'],
            [['discount_type', 'status'], 'integer'],
            [['discount_value'], 'number'],
            ['discount_value','default','value' => 0.00],
            ['expire_date','default','value' => date('Y-m-d',strtotime('+10 days'))],
            [['expire_date', 'created_at'], 'safe'],
            [['title', 'discount_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'discount_code' => 'Discount Code',
            'discount_type' => 'Discount Type',
            'discount_value' => 'Discount Value',
            'expire_date' => 'Expire Date',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_context".
 *
 * @property integer $id
 * @property string $payment_mode
 * @property double $item_total
 * @property double $shipping
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $payment_date
 * @property string $gateway_response
 *
 * @property Order $order
 * @property User $user
 */
class PaymentContext extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_context';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_total', 'shipping', 'order_id', 'user_id', 'payment_date'], 'required'],
            [['item_total', 'shipping'], 'number'],
            [['order_id', 'user_id'], 'integer'],
            [['gateway_response'], 'string'],
            [['payment_mode'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'payment_mode' => Yii::t('app', 'Payment Mode'),
            'item_total' => Yii::t('app', 'Item Total'),
            'shipping' => Yii::t('app', 'Shipping'),
            'order_id' => Yii::t('app', 'Order ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'payment_date' => Yii::t('app', 'Payment Date'),
            'gateway_response' => Yii::t('app', 'Gateway Response'),
        ];
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

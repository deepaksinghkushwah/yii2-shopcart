<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $user_id
 * @property double $items_total
 * @property double $shipping
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status
 * @property integer $shipping_address_id
 * @property integer $billing_address_id
 * @property LogOrder[] $logOrders
 * @property User $user
 * @property OrderAddress[] $orderAddresses
 * @property OrderDetail[] $orderDetails
 * @property PaymentContext[] $paymentContexts
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['user_id', 'created_by', 'updated_by', 'status', 'shipping_address_id', 'billing_address_id'], 'integer'],
            [['items_total', 'shipping'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    
    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'value' => date('Y-m-d H:i:s'),
            ],
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'value' => Yii::$app->user->id,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'items_total' => 'Items Total',
            'shipping' => 'Shipping',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'shipping_address_id' => 'Shipping Address ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogOrders()
    {
        return $this->hasMany(LogOrder::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderAddresses()
    {
        return $this->hasMany(OrderAddress::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentContexts()
    {
        return $this->hasMany(PaymentContext::className(), ['order_id' => 'id']);
    }
}

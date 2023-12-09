<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "featured_product".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $created_at
 
 *
 * @property Product $product
 */
class FeaturedProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'featured_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'created_at'], 'required'],
            [['product_id', ], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'created_at' => 'Add Date',
            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}

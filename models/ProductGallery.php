<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_gallery".
 *
 * @property int $id
 * @property int $product_id
 * @property string $image
 *
 * @property Product $product
 */
class ProductGallery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'image'], 'required'],
            [['product_id'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }
    
    

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',            
            'image' => 'Image',           
            'product_id' => 'Product',
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

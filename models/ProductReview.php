<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_review".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $parent_id
 * @property string $title
 * @property string $review
 * @property integer $rating
 * @property integer $created_at
 * @property integer $user_id
 *
 * @property Product $product
 */
class ProductReview extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'title', 'review', 'created_at'], 'required'],
            [['product_id', 'parent_id', 'rating', 'user_id'], 'integer'],
            [['review'], 'string'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'title' => Yii::t('app', 'Title'),
            'review' => Yii::t('app', 'Review'),
            'rating' => Yii::t('app', 'Rating'),
            'created_at' => Yii::t('app', 'Add Date'),
            'user_id' => Yii::t('app', 'User ID'),
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

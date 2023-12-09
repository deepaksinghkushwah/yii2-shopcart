<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property string $id
 * @property integer $cat_id
 * @property string $title
 * @property string $alias
 * @property string $detail
 * @property string $image
 * @property double $price
 * @property integer $created_at
 * @property int $status
 *
 * @property Category $cat
 */
class Product extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cat_id', 'title', 'alias', 'created_at'], 'required'],
            ['alias', 'unique', 'when' => function($model) {
                    
                    return !$model->isNewRecord && static::getOldAlias($model->id)!==$model->alias;
                }],
            [['cat_id'], 'integer'],
            [['detail', 'status'], 'string'],
            ['image', 'file', 'extensions' => 'png, jpg, jpeg, gif', 'on' => ['insert', 'update']],
            [['price'], 'number'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cat_id' => 'Category',
            'title' => 'Title',
            'alias' => 'Alias',
            'detail' => 'Detail',
            'image' => 'Image',
            'price' => 'Price',
            'created_at' => 'Add Date',
            'status' => 'Published',
        ];
    }

    function behaviors() {
        return [
            [
                'class' => \mohorev\file\UploadImageBehavior::class,
                'attribute' => 'image',
                'scenarios' => ['default','insert', 'update'],
                'placeholder' => '@web/images/product/product.jpg',
                'path' => Yii::$app->params['productPhotoPathOs'], //'@webroot/images/products/',
                'url' => Yii::$app->params['productPhotoPathWeb'],//'@web/images/products/',
                'thumbs' => [
                    'thumb' => ['width' => 400, 'quality' => 90],                    
                    'preview' => ['width' => 100, 'height' => 70],
                ],
            ],
            [
                'class' => \yii\behaviors\SluggableBehavior::class,
                'attribute' => 'alias',
                'slugAttribute' => 'alias',
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat() {
        return $this->hasOne(Category::class, ['id' => 'cat_id']);
    }

    public function beforeSave($insert) {
        $this->alias = str_replace(" ", "-", $this->alias);
        return true;
    }

    public static function getOldAlias($id) {
        return static::findOne($id)->alias;
    }

}

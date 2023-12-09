<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $alias
 * @property integer $created_at
 * @property integer $updated_at
 * @property int $status
 */
class Page extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'page';
    }

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\SluggableBehavior::className(),
                'attribute' => 'content',
                'slugAttribute' => 'alias',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'created_at'], 'required'],
            ['alias', 'unique'],
            [['content'], 'string'],
            ['status','integer'],
            
            [['title', 'alias'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'alias' => 'Alias',
            'created_at' => 'Add Date',
            'updated_at' => 'Modify Date',
            'status' => 'Published',
        ];
    }

}

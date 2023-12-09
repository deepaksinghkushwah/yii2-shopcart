<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userprofile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $fullname
 * @property string $contact_mobile
 * @property string $address_line1
 * @property string $city
 * @property string $county
 * @property string $postcode
 * @property string $country
 * @property string $image
 *
 * @property User $user
 */
class Userprofile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userprofile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'fullname','city','county','country'], 'required'],
            [['user_id'], 'integer'],
            [['image'], 'file', 'extensions' => 'gif, jpg, jpeg, png'],
            ['image', 'required', 'on' => 'create', 'skipOnEmpty' => false],
            [['fullname', 'contact_mobile', 'address_line1', 'city', 'county', 'postcode', 'country'], 'string', 'max' => 255]
        ];
    }

    public function beforeValidate() {
        parent::beforeValidate();
        $fields = [
            'fullname', 'contact_mobile', 'address_line1', 'postcode'
        ];
        foreach ($fields as $field) {
            $this->{$field} = strip_tags(\yii\helpers\HtmlPurifier::process($this->{$field}));
        }
        return true;    
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'fullname' => 'Full Name',
            'contact_mobile' => 'Contact Mobile',
            'address_line1' => 'Address',
            'city' => 'City',
            'county' => 'State',
            'postcode' => 'Postcode',
            'country' => 'Country',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

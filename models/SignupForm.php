<?php

namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $email;
    public $password;
    public $reg_key;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup($status = 0, $profile) {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = $status;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->reg_key = $this->generateregToken();
            if ($user->save()) {                
                $profile->user_id = $user->id;
                $profile->fullname = $user->username;
                $profile->image = \yii\web\UploadedFile::getInstance($profile, 'image');
                if ($profile->image) {
                    $name = uniqid() . '.' . $profile->image->extension;
                    $profile->image->saveAs(Yii::$app->basePath . '/web/images/profile/' . $name);
                    $profile->image = $name;
                } else {
                    $profile->image = 'noimg.jpg';
                }
                $profile->save();
                Yii::$app->authManager->assign(Yii::$app->authManager->getRole('Registered'), $user->id);
                $user['pass'] = trim($this->password);
                $user['name'] = $this->username;
                return $user;
            }
        }

        return null;
    }

    function generateregToken() {
        return Yii::$app->security->generateRandomString() . time() . rand();
    }

}

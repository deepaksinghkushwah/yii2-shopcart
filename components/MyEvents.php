<?php
namespace app\components;
use yii;
/**
 * Description of MyEvents
 *
 * @author Deepak Singh Kushwah
 */
class MyEvents {
    public static function beforeLogin(){
        \Yii::$app->session->set('session_id', \Yii::$app->session->id);
    }
    
    public static function afterLogin(){
        //\Yii::$app->db->createCommand("UPDATE cart SET session_id = '".\Yii::$app->session->id."', user_id = '".Yii::$app->user->id."' WHERE session_id = '".\Yii::$app->session->get('session_id')."'")->execute();
        \Yii::$app->session->set('session_id', \Yii::$app->session->id);
    }
}


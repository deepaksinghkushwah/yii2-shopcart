<?php

namespace app\controllers;
use Yii;
class CronController extends \yii\web\Controller
{
    public function actionIndex()
    {
        // delete from order table which record are from paypal and not completed by today.
        $sql = "DELETE FROM `order` WHERE id IN (SELECT order_id FROM payment_context WHERE payment_mode = 'paypal_rest_api' AND payment_status = '1' AND DATE(payment_date) < '".date('Y-m-d')."')";
        Yii::$app->db->createCommand($sql)->execute();
        
        // delete from order table which records do no have user id and one day old, i.e. records which are not processed by user
        $sql = "DELETE FROM `order` WHERE user_id = '' AND DATE(created_at) < '".date('Y-m-d',strtotime('-1 days'))."'";
        Yii::$app->db->createCommand($sql)->execute();
    }

}

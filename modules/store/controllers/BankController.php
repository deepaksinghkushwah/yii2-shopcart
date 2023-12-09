<?php

namespace app\modules\store\controllers;

class BankController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //\Yii::$app->db->createCommand('DELETE FROM cart where user_id=' . \Yii::$app->user->id)->execute();
        return $this->render('index');
    }

}

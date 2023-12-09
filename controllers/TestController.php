<?php

namespace app\controllers;
use Yii;
class TestController extends \yii\web\Controller
{
		
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionSendMail(){
        $content = "<B>Hello There</b>";
        
        $mail = Yii::$app->mailer->compose('test',['content' => $content]); //Yii::$app->mailer->compose(['html' => 'enquiry'], ['email_template_data' => $email_template_data]);
        $sub = "Test Message";
        $mail->setTo('test1@localhost.com');
        
        $mail->setCc(Yii::$app->params['settings']['admin_email']);
        //$mail->setBcc($emailData->bcc_emails);
        $mail->setFrom(Yii::$app->params['settings']['admin_email']);
        $mail->setSubject($sub);
        return $mail->send();
    }
    
    public function actionCat(){
        $catId = 13;
        $rows = \app\components\CategoryHelper::getCategoryParent($catId);
        echo "<pre>";
        print_r($rows);
        echo "</pre>";
    }

}

<?php

namespace app\components;

use yii;

class Settings implements yii\base\BootstrapInterface {

    private $db;

    public function __construct() {        
        $this->db = \Yii::$app->db;
    }

    public function bootstrap($app) {
        // Get settings from database        
        $sql = $this->db->createCommand("SELECT `key`,`value` FROM setting");
        $settings = $sql->queryAll();        

        // Now let's load the settings into the global params array

        foreach ($settings as $key => $val) {
            if($val['key'] == 'paypal_client_id'){
                Yii::$app->params['payPalClientId'] = $val['value'];
            } elseif ($val['key'] == 'paypal_client_secret'){
                Yii::$app->params['payPalClientSecret'] = $val['value'];
            } 
            Yii::$app->params['settings'][$val['key']] = $val['value'];
        }
    }

}

<?php
namespace app\components;
use yii;

class ProductHelper {
    public static function displayProductPrice($amt){
        echo \app\models\Setting::findOne(['key' => 'currency'])->value.number_format($amt,2);
    }
    
    public static function showAmt($amt){
        return \app\models\Setting::findOne(['key' => 'currency'])->value.number_format($amt,2);
    }
}

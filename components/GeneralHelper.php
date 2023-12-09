<?php

namespace app\components;

use yii;

class GeneralHelper extends yii\web\View {

    public static function addFancyBox() {        
        $view = \Yii::$app->view;
        \Yii::$app->view->registerCssFile(yii\helpers\BaseUrl::base() . '/js/fancybox/jquery.fancybox.min.css');
        \Yii::$app->view->registerJsFile(yii\helpers\BaseUrl::base() . '/js/fancybox/jquery.fancybox.min.js', ['position' => $view::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
    }

    public function addSiteCss() {
        
    }

    public static function getErrorAsString($model) {
        $str = "";
        foreach ($model->errors as $err) {
            if (is_array($err)) {
                foreach ($err as $error) {
                    $str.=$error . "<br/>";
                }
            } else {
                $str .= $err . "<br/>";
            }
        }
        return $str;
    }

}

<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FrameAsset extends AssetBundle
{
    public $basePath = '@web/themes/frame';
    public $baseUrl = '@web';
    public $js = [
        'js/tree/js/jquery.simpletree.js',
    ];
    public $css = [
        'themes/frame/views/files/css/lavish-bootstrap.css',
        //'themes/frame/views/files/css/bootstrap-theme.min.css',
        'themes/frame/views/files/css/site.css',
        'css/site.css',
        'js/tree/css/simpletree.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        //'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

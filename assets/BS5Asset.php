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
class BS5Asset extends AssetBundle
{
    public $basePath = '@web/themes/bs5';
    public $baseUrl = '@web';
    public $js = [
        'js/tree/js/jquery.simpletree.js',
        'themes/bs5/views/files/js/popper.min.js',
        'themes/bs5/views/files/js/bootstrap.min.js',
        
    ];
    public $css = [
        'themes/bs5/views/files/css/bootstrap.min.css',
        'themes/bs5/views/files/css/style.css',
        'js/tree/css/simpletree.css',
    ];
    public $depends = [
        //'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        //'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

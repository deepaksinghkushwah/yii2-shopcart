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
class AdminAsset extends AssetBundle
{
    public $basePath = '@web/themes/admin';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
         'js/tree/css/simpletree.css',
        '/js/fancybox/jquery.fancybox.min.css',
    ];
    public $js = [
        'themes/admin/views/files/dist/js/app.js',
        'js/tree/js/jquery.simpletree.js',
        '/js/fancybox/jquery.fancybox.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
         
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

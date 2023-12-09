<?php

use kartik\mpdf\Pdf;

Yii::setAlias('@themes', dirname(__DIR__) . '/web/themes');
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'storecart',
    'name' => 'ShopStop',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'app\components\Settings',
        'app\modules\store\components\StoreBootstrap'
    ],
    'container' => [
        'definitions' => [
            'yii\data\Pagination' => ['pageSize' => 50], //'maxButtonCount' => 5
            'yii\widgets\LinkPager' => ['firstPageLabel' => 'First', 'lastPageLabel' => 'Last'],
        ],
        'singletons' => [
        // Dependency Injection Container singletons configuration
        ]
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
        ],
        'backend' => [
            'class' => 'app\modules\backend\Backend',
        ],
        'store' => [
            'class' => 'app\modules\store\Store',
        ],
    ],
    'components' => [
         'PayPalRestApi' => [
            'class' => 'app\modules\store\components\PayPalRestApi',
            'redirectUrl' => '/store/paypal/make-payment',             
        ],
        'pdf' => [
            'class' => Pdf::classname(),
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'Invoice.pdf',
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'cssFile' => '@themes/frame/views/files/css/bootstrap.min.css',
        ],
        'assetManager' => [
            'bundles' => [
                /*'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                        'js/jquery.js',
                    ]
                ],*/
            ],
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
        // Set the following if you want to use DB component other than
        // default 'db'.
        // 'db' => 'mydb',
        // To override default session table, set the following
        // 'sessionTable' => 'my_session',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@themes/bs5/views',
                    '@app/modules/store/views' => '@themes/admin/views',
                    'baseUrl' => '@web',
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '4yJxvTfgBd7GEeGe3FJqt7Z24Lh9p1Pq',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/page/<alias>' => 'site/page',
                '/site/enquiry/<alias>' => 'site/enquiry',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'on beforeLogin' => ['\app\components\MyEvents', 'beforeLogin'],
            'on afterLogin' => ['\app\components\MyEvents', 'afterLogin'],
        ],
        'errorHandler' => [
            'errorAction' => '/site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => FALSE,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'localhost',
                'username' => 'admin@localhost.com',
                'password' => '123456',
                'port' => '25',
                'encryption' => '',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
//exit(YII_ENV);
if (YII_ENV == 'dev') {    
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
    $config['components']['assetManager']['forceCopy'] = true;
    $config['components']['db'] = require(__DIR__ . '/db.php');
    $config['components']['reCaptcha'] = require(__DIR__ . '/recaptcha.php');
    $config['as access'] = [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*', // add or remove allowed actions to this list            
            'debug/*',
            'gii/*',
            'store/catalog/apply-coupon',
            'store/catalog/removeitemfromcart',
            'store/catalog/add-to-cart',
            'store/catalog/index',
            'store/catalog/product-detail',
            'store/catalog/addtocart',
            'store/catalog/cart',
        ]
    ];    
} elseif (YII_ENV == 'demo') {
    
    // configuration adjustments for 'demo' environment
    //$config['bootstrap'][] = 'debug';
    //$config['modules']['debug'] = 'yii\debug\Module';

    $config['components']['assetManager']['forceCopy'] = true;

    $config['components']['db'] = require(__DIR__ . '/demo-db.php');
    $config['components']['reCaptcha'] = require(__DIR__ . '/demo-recaptcha.php');
    $config['components']['errorHandler'] = [
        'errorAction' => '/shop/web/site/error',
    ];
    $config['as access'] = [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*', // add or remove allowed actions to this list     
            'debug/*',
            'store/catalog/removeitemfromcart',
            'store/catalog/add-to-cart',
            'store/catalog/index',
            'store/catalog/product-detail',
            'store/catalog/addtocart',
            'store/catalog/cart',
        ]
    ];
} else {

    // configuration adjustments for 'live' environment

    $config['components']['assetManager']['forceCopy'] = true;

    $config['components']['db'] = require(__DIR__ . '/live-db.php');
    $config['components']['reCaptcha'] = require(__DIR__ . '/live-recaptcha.php');
    $config['as access'] = [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*', // add or remove allowed actions to this list   
            'store/catalog/index',
            'store/catalog/product-detail',
            'store/catalog/addtocart',
            'store/catalog/cart',
        ]
    ];
}

return $config;

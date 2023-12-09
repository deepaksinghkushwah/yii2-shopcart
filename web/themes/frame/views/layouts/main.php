<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\debug\Toolbar;

\app\assets\FrameAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo Html::encode($this->title); ?></title>
        <?= Html::csrfMetaTags() ?>
        <meta property='og:site_name' content='<?php echo Html::encode($this->title); ?>' />
        <meta property='og:title' content='<?php echo Html::encode($this->title); ?>' />
        <meta property='og:description' content='<?php echo Html::encode($this->title); ?>' />


        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php $this->head(); ?>        


    </head>

    <body>
        <?php $this->beginBody(); ?>

        <?php include(dirname(__FILE__) . '/menu.php'); ?>
        <div class="container maindiv">



            <div class="row">
                <div class="col-lg-12">
                    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) { ?>
                        <div class="alert alert-<?php echo $key; ?> ">
                            <?php echo $message; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php echo $content; ?>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">


                            &copy; <?= Yii::$app->name; ?> <?= date('Y') ?>    
                            <div class="pull-right">
                                <?= Html::a('Privacy & Policy', \yii\helpers\Url::to(['/page/privacy-policy'], true)); ?>
                                | <?= Html::a('Terms & Conditions', \yii\helpers\Url::to(['/page/terms-and-conditions'], true)); ?>
                                | Powered By: YII v<?= Yii::getVersion(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php $this->endBody(); ?>

    </body>
</html>
<?php $this->endPage(); ?>
<?php
/* @var $this yii\web\View */
//echo time()."<Br/>";
//echo time()+strtotime("+30 days");exit;
$this->title = Yii::$app->name;
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/slider/flexslider.css');
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/slider/jquery.flexslider.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJs("$('.flexslider').flexslider({    animation: 'slide',
    animationLoop: false,
    itemWidth: 210,
    itemMargin: 5,
    minItems: 2,
    maxItems: 4  });", $this::POS_END, 't1');
?>
<div class="site-index">

    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="<?= yii\helpers\Url::to(['images/banner1.jpg'], true); ?>" alt="" class="img-responsive">
                <div class="carousel-caption">
                    Title 1
                </div>
            </div>
            <div class="item">
                <img src="<?= yii\helpers\Url::to(['images/banner2.jpg'], true); ?>" alt="" class="img-responsive">
                <div class="carousel-caption">
                    Title 2
                </div>
            </div>
            <div class="item">
                <img src="<?= yii\helpers\Url::to(['images/banner3.jpg'], true); ?>" alt="" class="img-responsive">
                <div class="carousel-caption">
                    Title 3
                </div>
            </div>
            <div class="item">
                <img src="<?= yii\helpers\Url::to(['images/banner4.jpg'], true); ?>" alt="" class="img-responsive">
                <div class="carousel-caption">
                    Title 4
                </div>
            </div>

        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>



    </div>
    <!-- First bxslider  -->
    <div class="row">
        <div class="col-lg-12">
            <h3>Latest Products</h3>
            <div class="flexslider">
                <ul class="slides">

                    <?php
                    $products = \app\models\Product::find()->orderBy(['id' => SORT_DESC])->limit(10)->all();
                    foreach ($products as $product) {
                        ?>
                        <li>

                            <a href="<?= yii\helpers\Url::to(['/store/catalog/product-detail/' . $product->alias]); ?>">
                                <div class="imgContainer">
                                    <img src="<?= yii\helpers\Url::to(['/images/products/thumb-' . $product->image], true); ?>" style="width: 100%"/>
                                    <div class="centered">
                                        <?= substr($product->title,0,25).'...'; ?><br>
                                        <?= \app\components\ProductHelper::displayProductPrice($product->price); ?>

                                    </div>
                                </div>
                            </a>

                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>    


        </div>
        <div class="col-lg-12">
            <h3>Featured Products</h3>
            <div class="flexslider">
                <ul class="slides">
                    <?php
                    $fp = \app\models\FeaturedProduct::find()->orderBy(['id' => SORT_DESC])->all();
                    foreach ($fp as $p) {
                        ?>
                        <li>
                            
                            <a href="<?= yii\helpers\Url::to(['/store/catalog/product-detail/' . $p->product->alias]); ?>">
                                <div class="imgContainer">
                                    <img src="<?= yii\helpers\Url::to(['/images/products/thumb-' . $p->product->image], true); ?>" style="width: 100%"/>
                                    <div class="centered">
                                        <?= substr($p->product->title,0,25).'...'; ?><br>
                                        <?= \app\components\ProductHelper::displayProductPrice($p->product->price); ?>

                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>       
    </div>
    <p>&nbsp;</p>
</div>

<?php
$this->title = $model->title;
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/slider/flexslider.css');
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/slider/jquery.flexslider.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJs("$('.flexslider').flexslider({    animation: 'slide',
    animationLoop: false,
    itemWidth: 210,
    itemMargin: 5,
    minItems: 2,
    maxItems: 4  });", $this::POS_END, 't1');
?>
<h1><?= $this->title; ?></h1>
<div class="row">
    <div class="col-lg-6">
        <a class="fancybox" rel="gallery1" href="<?= \yii\helpers\Url::to([Yii::$app->params['productPhotoPathWeb'] . $model->image], true) ?>">
            <?= \yii\helpers\Html::img(yii\helpers\Url::to(['/images/products/' . $model->image], true), ['class' => 'img-thumbnail']) ?>
        </a>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <p><b>Price:</b> <?= \app\components\ProductHelper::displayProductPrice($model->price); ?></p>

                Any questions about this product? Let us know your <?= \yii\helpers\Html::a('Enquiry', yii\helpers\Url::to(['/site/enquiry/' . $model->alias], true), ['class' => 'btn btn-primary']); ?>
                <?php
                if (app\models\Setting::findOne(['key' => 'catalog_mode'])->value == 'No') {
                ?>

                    <p>
                        <?php
                        echo \yii\helpers\Html::beginForm(yii\helpers\Url::to(['/store/catalog/add-to-cart'], true), 'post');
                        echo \yii\helpers\Html::hiddenInput('alias', $model->alias);
                        echo "<div class='row'><div class='col-lg-3'>";
                        echo \yii\helpers\Html::input('number', 'qty', 1, ['class' => 'form-control']) . '<br>';
                        echo yii\helpers\Html::submitButton('Add To Cart', ['class' => 'btn btn-primary']);
                        echo "</div></div>";
                        echo \yii\helpers\Html::endForm();
                        ?>
                    </p>
                <?php
                }
                ?>
                <p><?= \yii\helpers\Html::a('Add to wishlist', yii\helpers\Url::to(['/store/catalog/addtowishlist', 'id' => $model->id], true), ['class' => 'btn btn-primary']); ?></p>

            </div>

        </div>
        <?php
        $fp = \app\models\RelatedProduct::find()->where("product_id = '" . $model->id . "'")->orderBy(['id' => SORT_DESC])->all();
        if ($fp) {
        ?>
            <h4>Related Products</h4>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="flexslider">
                        <ul class="slides">
                            <?php
                            foreach ($fp as $p) {
                            ?>
                                <li>

                                    <a href="<?= yii\helpers\Url::to(['/store/catalog/product-detail/' . $p->relatedProduct->alias]); ?>">
                                        <div class="imgContainer">
                                            <img src="<?= yii\helpers\Url::to(['/images/products/thumb-' . $p->relatedProduct->image], true); ?>" style="width: 100%" />
                                            <div class="centered">
                                                <?= substr($p->relatedProduct->title, 0, 25) . '...'; ?><br>
                                                <?= \app\components\ProductHelper::displayProductPrice($p->relatedProduct->price); ?>

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
        <?php } ?>

    </div>
</div>
<p></p>
<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-tab-pane" type="button" role="tab" aria-controls="desc-tab-pane" aria-selected="true">Description</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery-tab-pane" type="button" role="tab" aria-controls="gallery-tab-pane" aria-selected="false">Gallery</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review-tab-pane" type="button" role="tab" aria-controls="review-tab-pane" aria-selected="false">Review</button>
            </li>
            
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="desc-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <?=$model->detail?>
            </div>
            <div class="tab-pane fade" id="gallery-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <?=Yii::$app->controller->renderPartial('gallery', ['pid' => $model->id])?>
            </div>
            <div class="tab-pane fade" id="review-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                <?=Yii::$app->controller->renderPartial('review', ['pid' => $model->id])?>
            </div>
        </div>
    </div>
</div>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="list-item">
    <div class="row">
        <div class="col-lg-3">
            <a href="<?=yii\helpers\Url::to(['/store/catalog/product-detail/'.$model->product->alias], true);?>"><?= \yii\helpers\Html::img(yii\helpers\Url::to(['/images/products/' . $model->product->image], true), ['class' => 'img-thumbnail']); ?></a>
        </div>
        <div class="col-lg-9">
            <div class="row">
                <div class="col-lg-12">
                    <h2><a href="<?=yii\helpers\Url::to(['/store/catalog/product-detail/'.$model->product->alias], true);?>"><?= $model->product->title; ?></a></h2>
                    <span class="pull-right">Price: <?= \app\components\ProductHelper::displayProductPrice($model->product->price) ?></span>
                </div>
                <div class="col-lg-12">
                    <?=  substr($model->product->detail, 0,200).'...';?>
                </div>
                <div class="col-lg-12">
                    <span class="pull-right">
                        <?=  \yii\helpers\Html::a('More...',yii\helpers\Url::to(['/store/catalog/product-detail/'.$model->product->alias]),['class' => 'btn btn-primary']);?>
                        <?=  Html::a('Remove from wishlist',Url::to(['/store/catalog/removewishlistitem','id' => $model->id]),['class' => 'btn btn-primary']);?>                        
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
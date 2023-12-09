<div class="list-item">
    <div class="row">
        <div class="col-lg-3">
            <a href="<?=yii\helpers\Url::to(['/store/catalog/product-detail/'.$model->alias], true);?>"><?= \yii\helpers\Html::img(yii\helpers\Url::to(['/images/products/' . $model->image], true), ['class' => 'img-thumbnail']); ?></a>
        </div>
        <div class="col-lg-9">
            <div class="row">
                <div class="col-lg-12">
                    <h2><a href="<?=yii\helpers\Url::to(['/store/catalog/product-detail/'.$model->alias], true);?>"><?= $model->title; ?></a></h2>
                    <span class="pull-right">Price: <?= \app\components\ProductHelper::displayProductPrice($model->price) ?></span>
                </div>
                <div class="col-lg-12">
                    <?=  substr($model->detail, 0,200).'...';?>
                </div>
                <div class="col-lg-12">
                    <span class="pull-right">
                        <?=  \yii\helpers\Html::a('More...',yii\helpers\Url::to(['/store/catalog/product-detail/'.$model->alias]),['class' => 'btn btn-primary']);?>                        
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
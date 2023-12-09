<?php
$rows = app\models\ProductGallery::findAll(['product_id' => $pid]);
if ($rows) {
    ?>
    <div class="row">
        <?php
        foreach ($rows as $row) {
            ?>
            <div class="col-md-2">
                <a class="fancybox" rel="gallery1" href="<?= \yii\helpers\Url::to([Yii::$app->params['productPhotoPathWeb'] . $row->image], true) ?>">
                    <img src="<?= \yii\helpers\Url::to([Yii::$app->params['productPhotoPathWeb'] . $row->image], true) ?>" class="img-responsive img-thumbnail">
                </a>
            </div>

            <?php
        }
        ?>
    </div>
    <?php
    unset($rows);
} else {
    echo "No gallery images found";
}



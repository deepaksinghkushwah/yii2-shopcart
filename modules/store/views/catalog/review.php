<?php

use app\models\ProductReview;
use yii\helpers\Html;
use yii\helpers\Url;

\app\components\GeneralHelper::addFancyBox();
$this->registerJs('$(".fancybox").fancybox();');
if (isset(Yii::$app->user->id)) {
    $review_of_current_user = ProductReview::findOne([
                'user_id' => Yii::$app->user->id,
                'product_id' => $pid
    ]);
    if ($review_of_current_user) {
        $text = "Update your review";
    } else {
        $text = "Add Review";
    }
    echo Html::a($text, Url::to([
                '/store/catalog/addreview',
                'pid' => $pid
                    ], true), [
        'class' => 'fancybox fancybox.iframe btn btn-primary pull-right'
    ]);
}
echo "<h3>Review & Rating</h3>";
$reviews = ProductReview::find()->where("product_id='$pid'")->all();
if (count($reviews) > 0) {
    foreach ($reviews as $row) {
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading"><?php echo $row->title; ?>, <?=date('d M Y',strtotime($row->created_at));?>
                <span class='pull-right'><?php echo str_repeat(Html::img(Url::to(['/images/star.png'], true)), $row->rating); ?></span>
            </div>
            <div class=panel-body" style="padding: 10px;"><?php echo $row->review; ?></div>
        </div>
        <?php
    }
} else {
    echo "Product not rated yet. Be first to write review.";
}

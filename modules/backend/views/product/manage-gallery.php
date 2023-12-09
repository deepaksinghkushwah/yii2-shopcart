<?php
/* @var $this yii\web\View */
/* @var $row app\models\ProductGallery */
$gallery = \app\models\ProductGallery::find()->where('product_id = ' . $productId)->orderBy(['id' => SORT_DESC])->all();

echo \yii\helpers\Html::hiddenInput("removeImageUrl", \yii\helpers\Url::to(['/backend/product/remove-gallery-image'],true),['id' => 'removeImageUrl']);
if ($gallery) {
    ?>
    <table class="table table-striped">
        <tr>
            <?php
            $c = 1;
            foreach ($gallery as $row) {
                ?>

                <td><?= \yii\helpers\Html::img(\yii\helpers\Url::to([Yii::$app->params['productPhotoPathWeb'] . $row->image], true), ['class' => 'img-responsive img-thumbnail']) ?></td>
                <td><a href="javascript:void(0);" onclick="removeImageFromGallery('<?=$row->id?>')"><i class="fa fa-trash-o"></i></a></td>

                <?php
                if ($c % 4 == 0) {
                    echo "</tr><tr>";
                }
                $c++;
            }
            ?>
        </tr>
    </table>
    <?php
}

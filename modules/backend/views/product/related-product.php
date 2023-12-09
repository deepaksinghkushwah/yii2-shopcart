<h3>Select related product for <?= \app\models\Product::findOne(['id' => $pid])->title;?></h3>
<?php
/* @var $this yii\web\View */
/* @var $model app\models\RelatedProduct */
/* @var $product app\models\Product */
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/backend/product/related-product.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
echo \yii\helpers\Html::hiddenInput("relatedProductToggleUrl", yii\helpers\Url::to(['/backend/product/toggle-related-product'],true),['id' => 'relatedProductToggleUrl']);
$allProducts = \app\models\Product::find()->where("status = 1 AND id != $pid")->all();
if ($allProducts) {
    ?>
    <table class="table table-striped">
        <tr>

            <?php
            $c = 1;
            foreach ($allProducts as $product) {
                $catinfo = app\components\CategoryHelper::getCategoryParent($product->cat_id);
                $rp = \app\models\RelatedProduct::findOne(['product_id' => $pid, 'related_product_id' => $product->id]);
                if($rp){
                    $currentStatus = 1;
                } else {
                    $currentStatus = 0;
                }
                $img = file_exists(Yii::$app->params['productPhotoPathOs'] . 'thumb-' . $product->image) ? Yii::$app->params['productPhotoPathWeb'] . 'thumb-' . $product->image : Yii::$app->params['productPhotoPathWeb'] . 'product.jpg';
                ?>
                <td align="center">
                    <div class="panel panel-default">
                        <div class='panel-heading'><?= strlen($product->title) > 40 ? substr($product->title, 0, 40) . '...' : $product->title; ?></div>
                        <div class='panel-body'><img style="max-height: 150px" src="<?= $img; ?>" class="img-thumbnail img-responsive"><br>
                        <b><?= implode(" -> ",$catinfo)?> </b>
                        </div>
                        <div class="panel-footer">
                            <label>
                                <input <?=$currentStatus ? 'checked="checked"' : '';?> type='checkbox' class="toggleRelatedProduct" value="<?= $pid . '_' . $product->id ?>">&nbsp;Click to <?=$currentStatus ? 'remove' : 'add'?>
                            </label>
                        </div>
                    </div>                    
                </td>
                <?php
                if ($c % 6 == 0) {
                    echo "</tr><tr>";
                }
                $c++;
            }
            ?>
        </tr>
    </table>
    <?php
}


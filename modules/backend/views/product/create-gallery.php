<?php

use yii\helpers\Html;
use yii\helpers\Url;
use \yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductGallery */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/dropzone/dropzone.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/backend/product/gallery.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/dropzone/dropzone.css');
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/dropzone/basic.css');
?>




<div class="product-form">
    <h1>Upload Product Images</h1>
    <p><a href="<?= Url::to(['/backend/product/index'],true)?>" class="btn btn-primary">Back to products</a></p>
   <?php
    echo Html::beginForm(yii\helpers\Url::to(['/backend/product/upload-gallery','product_id' => $productId], true), 'post', [
        'enctype' => 'multipart/form-data',
        'class' => 'dropzone',
        'id' => 'myAwesomeDropzone',
    ]);
    echo Html::hiddenInput("product_id", $productId);
    ?>

    <div class="fallback">
        <?= Html::fileInput('file', '', ['accept' => 'image/*']); ?>
    </div>

    <?php echo Html::endForm(); ?>

</div>
<?=$this->render('manage-gallery',['productId' => $productId])?>
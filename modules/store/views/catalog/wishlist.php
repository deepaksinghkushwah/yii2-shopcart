<?php
/* @var $this yii\web\View */
$this->title = "Wishlist";
//$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/shop/index.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
?>
<h1>Wishlist</h1>
<div class="row">    
    <div class="col-lg-12">
        
        <?=
        \yii\widgets\ListView::widget([
            'dataProvider' => $model,
            'itemView' => '_wishlist',
        ]);
        ?>
    </div>
</div>
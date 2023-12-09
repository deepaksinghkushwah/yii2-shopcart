<?php
/* @var $this yii\web\View */
$this->title = "Shop";
//$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/shop/index.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="row">
    <div class='col-lg-3'>
        <?php
        (new app\components\CategoryHelper)->drawTree();
        ?>                

    </div>
    <div class="col-lg-9">
        <?= app\modules\store\components\SearchWidget::widget();?>
        <div class="row">
            <div class="col-lg-12">
                <h1>
                    <?php
                    if ($cat_id != 0) {
                        if(!empty($q)){
                            echo "<b>'$q'</b> in '" . \app\models\Category::findOne(['id' => $cat_id])->cat_name . "' Category";
                        } else {
                            echo "Product(s) From '" . \app\models\Category::findOne(['id' => $cat_id])->cat_name . "' Category";
                        }
                        
                    } else {
                        if(!empty($q)){
                            echo "Search <b>'$q'</b> in all categories";
                        } else {
                            echo "Product(s) From All Categories";
                        }
                        
                    }
                    ?>
                </h1>
            </div>
        </div>
        <?=
        \yii\widgets\ListView::widget([
            'dataProvider' => $products,
            'itemView' => 'product-list',
        ]);
        ?>
    </div>
</div>
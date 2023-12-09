<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/backend/product/index.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">


    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        /* 'filterModel' => $searchModel, */
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'cat_id' => [
                'label' => 'Category',
                'value' => function($model) {
                    return $model->cat->cat_name;
                },
            ],
            'title',
            [
                'label' => 'Is Featured',
                'value' => function($model) {
                    $fp = \app\models\FeaturedProduct::findOne(['product_id' => $model->id]);
                    if ($fp) {
                        return '<i class="glyphicon glyphicon-ok"></i>';
                    } else {
                        return '<i class="glyphicon glyphicon-remove"></i>';
                    }
                },
                'format' => 'html'
            ],
            'image' => [
                'label' => 'Image',
                'value' => function($model) {
                    return Html::img('@web/images/products/preview-' . $model->image, ['class' => 'img-thumbnail']);
                },
                'format' => 'raw',
            ],
            // 'price',
            // 'add_date',
            // 'published',
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '120px'],
                'template' => '{gallery} {featured} {related} {update} {delete}',
                'buttons' => [
                    'gallery' => function($url, $model) {
                        return Html::a("<i class='glyphicon glyphicon-picture'></i>", \yii\helpers\Url::to(['/backend/product/gallery', 'product_id' => $model->id], true), ['title' => 'Gallery']);
                    },
                    'featured' => function($url, $model) {
                        return Html::a("<i class='glyphicon glyphicon-certificate'></i>", 'javascript:void(0);', ['title' => 'Toggle product featured', 'class' => 'make-featured', 'data-url' => \yii\helpers\Url::to(['/backend/product/toggle-product-featured', 'product_id' => $model->id], true)]);
                    },
                    
                    'related' => function($url, $model) {
                        return "<a title='Setup related product' data-fancybox data-type='iframe' class='related_product' href='".\yii\helpers\Url::to(['/backend/product/related-product', 'pid' => $model->id], true)."'><i class='glyphicon glyphicon-link'></i></a>";                     
                    }
                ]
            ],
        ],
    ]);
    ?>

</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DiscountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Discounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-index">



    <p>
        <?= Html::a('Create Discount', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'discount_code',
            'discount_type' => [
                'label' => 'Type',
                'value' => function($model) {
                    return Yii::$app->params['discountTypes'][$model->discount_type];
                },
                'attribute' => 'discount_type',
                'filter' => Html::dropDownList(
                        'DiscountSearch[discount_type]', (isset($_REQUEST['DiscountSearch']['discount_type']) ? $_REQUEST['DiscountSearch']['discount_type'] : ''), Yii::$app->params['discountTypes'], [
                    'class' => 'form-control',
                    'prompt' => 'Select Any'
                        ]
                ),
            ],
            'discount_value',
            'expire_date' => [
                'label' => 'Expire Date',
                'value' => function($model) {
                    return $model->expire_date;
                },
                'attribute' => 'expire_date',
                'filter' => yii\jui\DatePicker::widget([
                    'name' => 'DiscountSearch[expire_date]',
                    'value' => (isset($_REQUEST['DiscountSearch']['expire_date']) ? $_REQUEST['DiscountSearch']['expire_date'] : ''),
                    //'dateFormat' => 'yyyy-MM-dd',
                ])
            ],
            'status' => [
                'label' => 'Status',
                'value' => function($model) {
                    return Yii::$app->params['discountTypes'][$model->status];
                },
                'attribute' => 'status',
                'filter' => Html::dropDownList(
                        'DiscountSearch[status]', (isset($_REQUEST['DiscountSearch']['status']) ? $_REQUEST['DiscountSearch']['status'] : ''), Yii::$app->params['status'], [
                    'class' => 'form-control',
                    'prompt' => 'Select Any'
                        ]
                ),
            ],
            ['class' => 'yii\grid\ActionColumn','template' => '{update} {delete}','headerOptions' => ['width' =>'100px']],
        ],
    ]);
    ?>


</div>

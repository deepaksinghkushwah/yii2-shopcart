<?php
$this->title = "Orders History";
\app\components\GeneralHelper::addFancyBox();
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/store/order-history.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
?>
<h1><?= $this->title; ?></h1>
<?=
yii\grid\GridView::widget([
    'dataProvider' => $model,
    'columns' => [
        // Simple columns defined by the data contained in $dataProvider.
        // Data from the model's column will be used.
        'id' => ['label' => '#Order Number', 'value' => function($model) {
                return $model->id;
            }],
        'final_order_amount' => [
            'label' => 'Total',
            'value' => function($model) {
                return app\components\ProductHelper::showAmt($model->final_order_amount);
            },
            'format' => 'html',
        ],
        
        [
            'label' => 'Order Date',
            'value' => function($model) {
                return date('d M Y', strtotime($model->created_at));
            }
        ],
        'status' => [
            'label' => 'Status',
            'value' => function($model) {


                return \app\modules\store\components\StoreGlobals::$orderStatus[$model->status];
            }
        ],
        [
            'label' => 'Payment',
            'format' => 'html',
            'value' => function($model) {
                $pc = \app\models\PaymentContext::findOne(['order_id' => $model->id]);
                if ($model->status == 1 && $pc->payment_mode == 'paypal_rest_api') {
                    $ctx = \app\models\PaymentContext::findOne(['order_id' => $model->id]);
                    return yii\helpers\Html::a("Pay Now", \yii\helpers\Url::to(['/store/catalog/load-order', 'ctxid' => $ctx->id,'order_id' => $model->id], true), ['class' => 'btn btn-xs btn-primary']);
                } else {
                    return "n/a";
                }
            },
        ],
        [
            'label' => '',
            'value' => function($model) {
                $showItem = "<a href='". yii\helpers\Url::to(['/store/catalog/order-detail', 'id' => $model->id], true)."' data-fancybox data-type='iframe' class='fancybox'>Detail</a>";
                $printInvoive = "<a href='". yii\helpers\Url::to(['/store/catalog/download-invoice', 'id' => $model->id], true)."' data-fancybox data-type='iframe' class='fancybox'>Print Invoice</a>";
                return ($showItem . " | " . $printInvoive);
            },
            'format' => 'raw',
        ],
    ],
]);

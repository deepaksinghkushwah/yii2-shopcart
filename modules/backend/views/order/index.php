<?php

$this->title = "Orders";
\app\components\GeneralHelper::addFancyBox();

$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/backend/order/index.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
echo yii\helpers\Html::hiddenInput('ajaxURL', \yii\helpers\Url::to(['/backend/order/update-order']), ['id' => 'ajaxURL']);
?>
<?=

yii\grid\GridView::widget([
    'dataProvider' => $model,
    'columns' => [
        // Simple columns defined by the data contained in $dataProvider.
        // Data from the model's column will be used.
        'id' => ['label' => '#Order Number', 'value' => function($model) {
                return $model->id;
            }],
        [
            'label' => 'Paypal/Bank',
            'value' => function($model) {
                $pc = \app\models\PaymentContext::findOne(['order_id' => $model->id]);
                if ($pc) {
                    return $pc->payment_mode == 'bank' ? 'Bank' : 'Paypal';
                } else {
                    return 'n/a';
                }
            },
            'format' => 'html',
                    'headerOptions' => ['width' => '120px'],
        ],
        'items_total' => [
            'label' => 'Items Total',
            'value' => function($model) {
                return app\components\ProductHelper::showAmt($model->items_total);
            },
            'format' => 'html',
        ],
        'shipping' => [
            'label' => 'Shipping Amount',
            'value' => function($model) {
                return app\components\ProductHelper::showAmt($model->shipping);
            },
            'format' => 'html',
        ],
        'created_at' => [
            'label' => 'Order Date',
            'value' => function($model) {
                return date('d M Y', strtotime($model->created_at));
            },
                    'headerOptions' => ['width' => '120px'],
        ],
        'status' => [
            'label' => 'Status',
            'value' => function($model) {
                return yii\helpers\Html::dropDownList('cStatus', $model->status, \app\modules\store\components\StoreGlobals::$orderStatus, ['class' => 'cStatus form-control']);
            },
            'format' => 'raw',
                    'headerOptions' => ['width' => '220px'],
        ],
        [
            'label' => '',
            'value' => function($model) {
                $items = "<a data-fancybox data-type='iframe' class='fancybox btn btn-primary btn-xs' href='".yii\helpers\Url::to(['/backend/order/order-detail', 'id' => $model->id], true)."'>Show Items</a>&nbsp;";
                $items .= "<a data-fancybox data-type='iframe' class='fancybox btn btn-primary btn-xs' href='".yii\helpers\Url::to(['/backend/order/invoice', 'id' => $model->id], true)."'>Invoice</a>";
                return $items;
            },
            'format' => 'raw',
                    'headerOptions' => ['width' => '200px'],
        ],
    ],
]);
?>
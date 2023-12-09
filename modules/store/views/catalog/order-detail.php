<?php
\app\assets\FrameAsset::register($this);
$subtotal = 0.00;
$grandTotal = 0.00;
$shipping = $order->shipping;
$bill = app\models\OrderAddress::findOne(['order_id' => $order->id, 'address_type' => 2]);
//echo "<pre>";print_r($bill);exit;
$ship = app\models\OrderAddress::findOne(['order_id' => $order->id, 'address_type' => 1]);
$paymentContext = \app\models\PaymentContext::findOne(['order_id' => $order->id]);
$paymentStatus = \app\modules\store\components\StoreHelper::getPaymentStatusAsString($paymentContext);
$orderStatus = \app\modules\store\components\StoreHelper::getOrderStatusAsString($order);
?>
<style>
    table.paleBlueRows {
        font-family: "Times New Roman", Times, serif;
        border: 1px solid #FFFFFF;
        background-color: #EEEEEE;
        width: 100%;

    }
    table.paleBlueRows td, table.paleBlueRows th {
        border: 1px solid #FFFFFF;
        padding: 3px 2px;
    }
    table.paleBlueRows tbody td {
        font-size: 13px;
        color: #42383C;
        text-align: center;
    }
    table.paleBlueRows thead {
        background: #A19EA2;
        background: -moz-linear-gradient(top, #b8b6b9 0%, #aaa7ab 66%, #A19EA2 100%);
        background: -webkit-linear-gradient(top, #b8b6b9 0%, #aaa7ab 66%, #A19EA2 100%);
        background: linear-gradient(to bottom, #b8b6b9 0%, #aaa7ab 66%, #A19EA2 100%);
    }
    table.paleBlueRows thead th {
        font-size: 17px;
        font-weight: bold;
        color: #FFFFFF;
        text-align: center;
        border-left: 2px solid #FFFFFF;
    }
    table.paleBlueRows thead th:first-child {
        border-left: none;
    }

    table.paleBlueRows tfoot {
        font-size: 14px;
        font-weight: bold;
        color: #333333;
        background: #A1B1BE;
        border-top: 3px solid #444444;
    }
    table.paleBlueRows tfoot td {
        font-size: 14px;
        text-align: right;
    }
</style>
<h1><?= "Order ID: #" . $order->id . "" ?></h1>
<table class="paleBlueRows">
    <tr>
        <td width="33%" align="left"><b>Order Status</b><Br> <?= $orderStatus; ?></td>
        <td width="33%" align="center"><b>Payment Status</b><Br> <?= $paymentStatus; ?></td>
        <td width="33%" align="right"><b>Payment Method</b><Br> <?= $paymentContext->payment_mode == 'bank' ? 'Bank (' . $paymentContext->gateway_response . ')' : 'Paypal'; ?></td>
    </tr>

</table>
<table class="paleBlueRows">
    <thead>
        <tr>
            <td colspan="5">
                <span style="float: left;">
                    <b>Bill To</b>
                    <p>
                        <?= $bill->contact_person; ?><br/>
                        <?= $bill->address_1 . ', ' . $bill->address_2; ?><br/>
                        <?= $bill->city0->name . ', ' . $bill->state0->name; ?><br/>
                        <?= $bill->postcode . ', ' . $bill->country0->name; ?><br/>
                        <?= $bill->contact_no != '' ? $bill->contact_no : ''; ?><br/>
                    </p>
                </span>
                <span style="float: right;">

                    <b>Ship To</b>
                    <p>
                        <?= $ship->contact_person; ?><br/>
                        <?= $ship->address_1 . ', ' . $ship->address_2; ?><br/>
                        <?= $ship->city0->name . ', ' . $ship->state0->name; ?><br/>
                        <?= $ship->postcode . ', ' . $ship->country0->name; ?><br/>
                        <?= $ship->contact_no != '' ? $ship->contact_no : ''; ?><br/>
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($model as $row) {
            ?>
            <tr>
                <td>
                    <a href="<?= yii\helpers\Url::to(['/store/catalog/product-detail/' . $row->p->alias], true); ?>">
                        <?= \yii\helpers\Html::img(yii\helpers\Url::to(['/images/products/' . $row->p->image], true), ['class' => 'img-thumbnail', 'width' => 100]); ?>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?= yii\helpers\Url::to(['/store/catalog/product-detail/' . $row->p->alias], true); ?>"><?= $row->p->title; ?></a>

                </td>
                <td align="right">
                    <span><?= \app\components\ProductHelper::displayProductPrice($row->price) ?></span>            
                </td>
                <td align="center"><?= $row->qty; ?></td>
                <td align="right"><?= \app\components\ProductHelper::showAmt($row->qty * $row->price); ?></td>
            </tr>
            <?php
            $subtotal += $row->qty * $row->price;
        }
        $grandTotal = $shipping + $subtotal;
        $orderTotal = \app\modules\store\components\StoreHelper::getFinalOrderTotal($order->id);
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td  colspan="4">Subtotal</td>
            <td><?= app\components\ProductHelper::displayProductPrice($orderTotal['orderItemTotal']); ?></td>
        </tr>  
        <tr>
            <td colspan="4">Shipping</td>
            <td>
                <?php
                echo app\components\ProductHelper::displayProductPrice($orderTotal['shipping']);
                ?>
            </td>
        </tr>
        <tr>
            <td align="right" colspan="4">Grand Total</td>
            <td>
                <?php
                
                if (!empty($orderTotal['coupon'])) {
                    echo $orderTotal['couponDisplay']."<Br>";
                    if ($orderTotal['orderItemTotal'] != $orderTotal['finalAmt']) {
                        $p = app\components\ProductHelper::showAmt($orderTotal['orderItemTotal']);
                        echo "<p style='text-decoration: line-through;'>" . $p . "</p>";
                    }
                }
                echo "<strong>" . app\components\ProductHelper::showAmt($orderTotal['finalAmt']) . "</strong>";
                ?>
            </td>
        </tr>


    </tfoot>

</table>
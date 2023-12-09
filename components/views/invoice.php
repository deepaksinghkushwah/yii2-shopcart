<?php
$colorGreen = '#f7ffe4 ';
$paymentContext = \app\models\PaymentContext::findOne(['order_id' => $order->id]);
$paymentStatus = \app\modules\store\components\StoreHelper::getPaymentStatusAsString($paymentContext);
$orderStatus = \app\modules\store\components\StoreHelper::getOrderStatusAsString($order);
$orderTotal = \app\modules\store\components\StoreHelper::getFinalOrderTotal($order->id);
?>
<div id="page-wrap" class="container bg-warning">
    <table style="border-collapse: 1" border="1" width="100%">
        <tr style="background-color: <?= $colorGreen ?>;">
            <td width="50%" style="padding: 5px">
                <h3><?= Yii::$app->name; ?></h3>
                <address>
                    Kushwah Sadan,Mohalla Khohara,<br/>
                    Near Arya Kanya School, Alwar, <br/>
                    Pin: 301001, Rajasthan (India)<br/>            
                </address></td>
            <td width="50%" align="right" style="padding: 5px">
                <h1>Invoice</h1>
                <address>
                    Date: <?= date(\app\models\Setting::findOne(['key' => 'date_format'])->value, strtotime($order->created_at)); ?><br/>
                    Customer: <?= $order->user->profile->fullname; ?>      <Br/>
                    Order ID: #<?= $order->id; ?>
                </address></td>
        </tr>
    </table>

</div>
<table  border="1" width="100%" style="background-color: <?= $colorGreen ?>;border-collapse: 1">
    <tr>
        <td width="33%" align="left"><b>Order Status</b><Br> <?= $orderStatus; ?></td>
        <td width="33%" align="center"><b>Payment Status</b><Br> <?= $paymentStatus; ?></td>
        <td width="33%" align="right"><b>Payment Method</b><Br> <?= $paymentContext->payment_mode == 'bank' ? 'Bank (' . $paymentContext->gateway_response . ')' : 'Paypal'; ?></td>
    </tr>

</table>

<table border="1" width="100%" style="background-color: <?= $colorGreen ?>;border-collapse: 1">
    <tr>
        <td style="padding: 5px; width: 50%;">
            <h4>Ship To</h4>
            <address>
                <?php
                $address = \app\models\ShippingAddress::findOne(['id' => $order->shipping_address_id]);
                echo $address->contact_person . "<br/>";
                echo $address->address_line1 . "<br/>";
                echo $address->address_line2 != '' ? $address->address_line2 . "<br/>" : '';
                echo $address->city0->name . ", " . $address->postcode . "<Br/>";
                echo $address->state0->name . ", " . $address->country0->name . "<br/>";
                ?>
            </address>
        </td>

        <td style="padding: 5px; width: 50%; text-align: right ">
            <h4>Bill To</h4>
            <address>
                <?php
                $address = \app\models\ShippingAddress::findOne(['id' => $order->billing_address_id]);
                echo $address->contact_person . "<br/>";
                echo $address->address_line1 . "<br/>";
                echo $address->address_line2 != '' ? $address->address_line2 . "<br/>" : '';
                echo $address->city0->name . ", " . $address->postcode . "<Br/>";
                echo $address->state0->name . ", " . $address->country0->name . "<br/>";
                ?>
            </address>
        </td>
    </tr>

</table>

<table border="1" width="100%" style="background-color: <?= $colorGreen ?>; border-collapse: 1;" cellpadding="3" cellspacing="3">
    <thead>
        <tr class="bg-warning">
            <th>Description</th>
            <th>Qty.</th>
            <th>Amount</th>
            <th>Total</th>
        </tr>
    </thead>    
    <tbody>
        <?php
        $orderDetail = app\models\OrderDetail::findAll(['order_id' => $order->id]);
        $subtotal = 0.00;
        foreach ($orderDetail as $od) {
            ?>
            <tr>
                <td align="left"><?= $od->p->title; ?></td>
                <td align="right"><?= $od->qty; ?></td>
                <td align="right"><?= \app\components\ProductHelper::showAmt($od->price); ?></td>
                <td align="right"><?= \app\components\ProductHelper::showAmt($od->qty * $od->price); ?></td>            
            </tr>
            <?php
            $subtotal += ($od->qty * $od->price);
        }
        $grandTotal = $subtotal + $order->shipping;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td align="right" colspan="3">Subtotal</td>
            <td align="right"><?= app\components\ProductHelper::displayProductPrice($orderTotal['orderItemTotal']); ?></td>
        </tr>  
        <tr>
            <td align="right" colspan="3">Shipping</td>
            <td align="right">
                <?php
                
                    echo app\components\ProductHelper::displayProductPrice($orderTotal['shipping']);
               
                ?>
            </td>
        </tr>
        <tr>
            <td align="right" colspan="3">Grand Total</td>
            <td align="right">
                <?php
                if (!empty($orderTotal['coupon'])) {
                    $p = app\components\ProductHelper::showAmt($orderTotal['orderItemTotal']);
                    echo $orderTotal['couponDisplay'] . "<p style='text-decoration: line-through;'>" . $p . "</p>";
                }
                echo "<strong>" . app\components\ProductHelper::showAmt($orderTotal['finalAmt']) . "</strong>";
                ?>
            </td>
        </tr>

       
        <tr>
            <td align="center" colspan="4" style="height: 200px;">Thank You For Your Business!</td>
        </tr>
    </tfoot>
</table>


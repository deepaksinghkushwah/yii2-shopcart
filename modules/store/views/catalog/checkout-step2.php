<?php
$this->title = "Shopping Cart";
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/store/checkout-step2.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$month = [];
$year = [];
foreach (range(1, 12) as $row) {
    $month[$row] = date("F", mktime(0, 0, 0, sprintf("%02d", $row)));
}
foreach (range(date('Y'), date('Y', strtotime('+10 years'))) as $row) {
    $year[$row] = $row;
}
$orderTotal = \app\modules\store\components\StoreHelper::getFinalOrderTotal(Yii::$app->session->get('orderId'));
?>
<h1><?= $this->title; ?></h1>

<?php if ($model) { ?>
    <?php echo yii\helpers\Html::beginForm(yii\helpers\Url::to(['/store/catalog/place-order']), 'post', ['name' => 'checkout-form', 'id' => 'checkout-form']); ?>
    <table class="table table-striped">
        <thead>
            <tr>
                 <th width="30%">Image</th>
                <th width="35%">Product</th>
                <th width="10%">Price</th>
                <th width="10%">QTY</th>
                <th width="15%">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $subtotal = 0.00;
            foreach ($model as $row) {
                ?>
                <tr>
                    <td><?= yii\helpers\Html::img(yii\helpers\Url::to(['/images/products/' . $row->p->image], true), ['class' => 'img-thumbnail', 'width' => '100']); ?></td>
                    <td>
                        <p><?= yii\helpers\Html::a($row->p->title, yii\helpers\Url::to(['/store/catalog/product-detail/' . $row->p->alias], true)); ?></p>

                    </td>
                    <td><?= app\components\ProductHelper::displayProductPrice($row->price); ?></td>
                    <td><?= $row->qty; ?></td>
                    <td><?= app\components\ProductHelper::displayProductPrice($row->qty * $row->price); ?></td>
                </tr>
                <?php
                $subtotal += ($row->price * $row->qty);
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td align="right" colspan="4">Subtotal</td>
                <td><?= app\components\ProductHelper::displayProductPrice($orderTotal['orderItemTotal']); ?></td>
            </tr>  
            <tr>
                <td align="right" colspan="4">Shipping</td>
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
                    if(!empty($orderTotal['coupon'])){
                        $p = app\components\ProductHelper::showAmt($orderTotal['orderItemTotal'] + $orderTotal['shipping']);
                        echo $orderTotal['couponDisplay']. "<p style='text-decoration: line-through;'>" .$p."</p>";
                    }
                    echo "<strong>".app\components\ProductHelper::showAmt($orderTotal['finalAmt'])."</strong>";
                    ?>
                </td>
            </tr>
        </tfoot>
    </table>
<table class="table table-bordered">


        <tr>
            <td width="40%">Payment Option</td>
            <td colspan="4">
                <input type='radio' checked="checked" name='payment_mode' value="bank"/> Bank Cheque<br/>
                <textarea rows="5" class="form-control" cols="50" name="bank_detail" id='bank_detail' style="display: auto;"></textarea><br/>                    
                <input type='radio' checked="checked"  name='payment_mode' value="paypal_rest_api"/> Paypal<Br/>

            </td>
        </tr>
        <tr>
            <td align="right" colspan="5">
                <?= yii\helpers\Html::submitButton('Place Order', ['class' => 'btn btn-primary btn-submit']); ?>
            </td>
        </tr>

    </table>
    <?php echo yii\helpers\Html::endForm(); ?>
<?php } else { ?>
    No item found in your cart.
<?php } ?>

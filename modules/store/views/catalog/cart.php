<?php
$this->title = "Shopping Cart";
?>
<h1><?= $this->title; ?></h1>

<?php if ($model) { ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th width="30%">Image</th>
                <th width="40%">Product</th>
                <th width="10%">Price</th>
                <th width="10%">QTY</th>
                <th width="10%">Amount</th>
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
                        <p><?= yii\helpers\Html::a("<i class='glyphicon glyphicon-remove-circle'></i> Remove Item", yii\helpers\Url::to(['/store/catalog/removeitemfromcart', 'id' => $row->id]), ['class' => 'btn btn-danger']); ?></p>
                    </td>
                    <td><?= app\components\ProductHelper::displayProductPrice($row->price); ?></td>
                    <td><?= $row->qty; ?></td>
                    <td><?= app\components\ProductHelper::displayProductPrice($row->qty * $row->price); ?></td>
                </tr>
                <?php
            }
            $orderTotal = \app\modules\store\components\StoreHelper::getFinalOrderTotal(Yii::$app->session->get('orderId'));
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
            <tr>
                <td align="left" colspan="4">
                    <?= \yii\helpers\Html::beginForm(yii\helpers\Url::to(['/store/catalog/apply-coupon'], true), 'get') ?>
                    <div class="row">
                        <div class="col-md-4"><input type="text" name="code" value="<?= $orderTotal['coupon'] ?>" class="form-control"></div>
                        <div class="col-md-2"><input type="submit" value="Apply Coupon" class="btn btn-primary"></div>                        
                    </div>
                    <?php
                    if (!empty($orderTotal['coupon'])) {
                        echo "<Br><strong>Coupon Applied: " . $orderTotal['coupon'] . "</strong>";
                    }
                    ?>
                    <?= \yii\helpers\Html::endForm(); ?>
                </td>
                <td>                
                </td>
            </tr>
            <tr>
                <td align="right" colspan="5">
                    <?= yii\helpers\Html::a('Proceed To Checkout', yii\helpers\Url::to(['/store/catalog/checkout-step1'], true), ['class' => 'btn btn-primary']); ?>
                </td>
            </tr>
        </tfoot>
    </table>

<?php } else { ?>
    No item found in your cart.
<?php } ?>

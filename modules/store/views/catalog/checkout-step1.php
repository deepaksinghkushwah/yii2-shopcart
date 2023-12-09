<?php
$this->title = "Shipping Information";
\app\components\GeneralHelper::addFancyBox();
$this->registerJs('$(".fancybox").fancybox();');
?>
<h1><?= $this->title; ?></h1>
<?= yii\helpers\Html::a('Add Address', yii\helpers\Url::to(['/store/catalog/add-shipping-address'], true), ['class' => 'btn btn-primary fancybox fancybox.iframe']); ?><br/><br/>

<?php
if ($model) {
    echo yii\helpers\Html::beginForm(yii\helpers\Url::to(['/store/catalog/checkout-step2']), 'post');
    ?>

    <div class="row">
        <div class="col-lg-6">
            <h3>Shipping Address</h3>
            <div class="row">
                
                <?php
                $c = 1;
                foreach ($model as $row) {
                    ?>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?= $row->contact_person; ?><input <?= $c == 1 ? 'checked="checked"' : ''; ?> class="pull-right" type="radio" name="ship_address_id" value="<?= $row->id ?>"/></div>
                            <div class="panel-body">
                                <address>
                                    <?= $row->address_line1 . "<br/>" ?>
                                    <?= $row->address_line2 != '' ? $row->address_line2 . "<br/>" : ''; ?>
                                    <?= $row->city0->name . ', ' . $row->postcode . "<br/>"; ?>
                                    <?= $row->state0->name . ', ' . $row->country0->name; ?>
                                </address>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>  
            </div>
        </div>
        <div class="col-lg-6">
            <h3>Billing Address</h3>
            <div class="row">
                <?php
                $c = 1;
                foreach ($model as $row) {
                    ?>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?= $row->contact_person; ?><input <?= $c == 1 ? 'checked="checked"' : ''; ?> class="pull-right" type="radio" name="bill_address_id" value="<?= $row->id ?>"/></div>
                            <div class="panel-body">
                                <address>
                                    <?= $row->address_line1 . "<br/>" ?>
                                    <?= $row->address_line2 != '' ? $row->address_line2 . "<br/>" : ''; ?>
                                    <?= $row->city0->name . ', ' . $row->postcode . "<br/>"; ?>
                                    <?= $row->state0->name . ', ' . $row->country0->name; ?>
                                </address>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>   
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <input type="submit" value="Continue Checkout" class="btn btn-primary"/>
        </div>
    </div>


    <?php
    echo yii\helpers\Html::endForm();
}
?>

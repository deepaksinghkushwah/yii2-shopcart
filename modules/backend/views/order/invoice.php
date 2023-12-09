<?php
app\assets\FrameAsset::register($this);
?>
<html>
    <head>
        <style>
            /*
         CSS-Tricks Example
         by Chris Coyier
         http://css-tricks.com
            */

            * { margin: 0; padding: 0; }
            body { font: 14px/1.4 Georgia, serif; }
            #page-wrap { width: 700px; margin: 0 auto; }

            textarea { border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none; }
            table { border-collapse: collapse; }
            table td, table th { border: 1px solid black; padding: 5px; }

            #header { height: 15px; width: 100%; margin: 20px 0; background: #222; text-align: center; color: white; font: bold 15px Helvetica, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }

            #address { width: 250px; height: 150px; float: left; }
            #customer { overflow: hidden; }

            #logo { text-align: right; float: right; position: relative; margin-top: 25px; border: 1px solid #fff; max-width: 540px; max-height: 100px; overflow: hidden; }
            #logo:hover, #logo.edit { border: 1px solid #000; margin-top: 0px; max-height: 125px; }
            #logoctr { display: none; }
            #logo:hover #logoctr, #logo.edit #logoctr { display: block; text-align: right; line-height: 25px; background: #eee; padding: 0 5px; }
            #logohelp { text-align: left; display: none; font-style: italic; padding: 10px 5px;}
            #logohelp input { margin-bottom: 5px; }
            .edit #logohelp { display: block; }
            .edit #save-logo, .edit #cancel-logo { display: inline; }
            .edit #image, #save-logo, #cancel-logo, .edit #change-logo, .edit #delete-logo { display: none; }
            #customer-title { font-size: 20px; font-weight: bold; float: left; }

            #meta { margin-top: 1px; width: 300px; float: right; }
            #meta td { text-align: right;  }
            #meta td.meta-head { text-align: left; background: #eee; }
            #meta td textarea { width: 100%; height: 20px; text-align: right; }

            #items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }
            #items th { background: #eee; }
            #items textarea { width: 80px; height: 50px; }
            #items tr.item-row td { border: 0; vertical-align: top; }
            #items td.description { width: 300px; }
            #items td.item-name { width: 175px; }
            #items td.description textarea, #items td.item-name textarea { width: 100%; }
            #items td.total-line { border-right: 0; text-align: right; }
            #items td.total-value { border-left: 0; padding: 10px; }
            #items td.total-value textarea { height: 20px; background: none; }
            #items td.balance { background: #eee; }
            #items td.blank { border: 0; }

            #terms { text-align: center; margin: 20px 0 0 0; }
            #terms h5 { text-transform: uppercase; font: 13px Helvetica, Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
            #terms textarea { width: 100%; text-align: center;}

            textarea:hover, textarea:focus, #items td.total-value textarea:hover, #items td.total-value textarea:focus, .delete:hover { background-color:#EEFF88; }

            .delete-wpr { position: relative; }
            .delete { display: block; color: #000; text-decoration: none; position: absolute; background: #EEEEEE; font-weight: bold; padding: 0px 3px; border: 1px solid; top: -6px; left: -22px; font-family: Verdana; font-size: 12px; }
            @media print {
            body {-webkit-print-color-adjust: exact;}
            }
        </style>
        
    </head>
    <body onload="window.print();">

        <div id="page-wrap" class="container bg-warning">
            <div class="row">
                <div class="col-lg-12">
                    <span class="pull-left">
                        <h3><?= Yii::$app->name; ?></h3>
                        <address>
                            Kushwah Sadan,Mohalla Khohara,<br/>
                            Near Arya Kanya School, Alwar, <br/>
                            Pin: 301001, Rajasthan (India)<br/>            
                        </address>
                    </span>

                    <span class="pull-right">
                        <h1>Invoice</h1>
                        <address>
                            Date: <?= date(\app\models\Setting::findOne(['key' => 'date_format'])->value, strtotime($order->created_at)); ?><br/>
                            Customer: <?= $order->user->profile->fullname; ?>      <Br/>
                            Order ID: #<?=$order->id;?>
                        </address>
                    </span>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-11 col-lg-offset-1">
                    <h4>Bill/Ship To</h4>
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
                </div>
            </div>

            <table class="table table-bordered">
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
                            <td><?= $od->p->title; ?></td>
                            <td><?= $od->qty; ?></td>
                            <td><?= \app\components\ProductHelper::showAmt($od->price); ?></td>
                            <td><?= \app\components\ProductHelper::showAmt($od->qty * $od->price); ?></td>            
                        </tr>
                        <?php
                        $subtotal+=($od->qty * $od->price);
                    }
                    $grandTotal = $subtotal + $order->shipping;
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td align="right" colspan="3">Subtotal</td>
                        <td><?= app\components\ProductHelper::showAmt($subtotal) ?></td>
                    </tr>
                    <tr>
                        <td align="right" colspan="3">Shipping</td>
                        <td><?= app\components\ProductHelper::showAmt($order->shipping) ?></td>
                    </tr>
                    <tr>
                        <td align="right" colspan="3"><b>Grand Total<b/></td>
                        <td><?= app\components\ProductHelper::showAmt($grandTotal) ?></td>
                    </tr>
                    <tr>
                        <td align="center" colspan="4" style="height: 200px;">Thank You For Your Business!</td>
                    </tr>
                </tfoot>
            </table>

        </div>

    </body>
</html>
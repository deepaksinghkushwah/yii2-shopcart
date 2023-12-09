<?php

namespace app\modules\store\components;

use Yii;

class StoreHelper {

    public static function getShippingPrice($address_id) {        
        return (float) Yii::$app->params['settings']['shipping_price'];
    }

    public static function sendOrderConfirmMail($orderId) {
        $order = \app\models\Order::findOne(['id' => $orderId]);
        $od = \app\models\OrderDetail::findAll(['order_id' => $orderId]);
        $content = Yii::$app->view->render('@app/modules/store/views/catalog/order-detail', ['order' => $order, 'model' => $od]);
        $user = \app\models\User::findOne(['id' => $order->user_id]);
        $mail = Yii::$app->mailer->compose('orderconfirm', ['content' => $content]); //Yii::$app->mailer->compose(['html' => 'enquiry'], ['email_template_data' => $email_template_data]);
        $sub = "Order Confirm";
        $mail->setTo($user->email);

        $mail->setCc(Yii::$app->params['settings']['admin_email']);
        //$mail->setBcc($emailData->bcc_emails);
        $mail->setFrom(Yii::$app->params['settings']['admin_email']);
        $mail->setSubject($sub);
        $data = $mail->send();
        return true;
    }

    /**
     * 
     * @param object $order
     * @return string
     */
    public static function getOrderStatusAsString($order) {
        if($order->status == 0){
            return "Order Placed";
        }
        return \app\modules\store\components\StoreGlobals::$orderStatus[$order->status];
    }

    /**
     * 
     * @param object $paymentContext
     * @return string
     */
    public static function getPaymentStatusAsString($paymentContext) {
        return \app\modules\store\components\StoreGlobals::$paymentStatus[$paymentContext->payment_status];
    }

    public static function payByPaypalRestAPI($ctxId) {
        $apiContext = self::getApiContext();
        $creditCard = new \PayPal\Api\CreditCard();
    }

    /**
     * Confirm order
     * @return type
     */
    public static function preConfirmOrder() {
        $payment_mode = Yii::$app->request->post('payment_mode', 'bank');

        $order = \app\models\Order::findOne(['id' => Yii::$app->session->get('orderId')]);
        

        //$order->add_date = date('Y-m-d H:i:s');
        //exit($order->add_date);
        $order->user_id = Yii::$app->user->id;
        $order->items_total = \app\models\OrderDetail::findBySql("SELECT SUM(qty*price) AS total FROM order_detail WHERE order_id = '" . Yii::$app->session->get('orderId') . "'")->scalar();
        $order->shipping = StoreHelper::getShippingPrice(Yii::$app->session->get('address_id'));
        $order->status = 1;
        $order->shipping_address_id = Yii::$app->session->get('ship_address_id');
        $order->billing_address_id = Yii::$app->session->get('bill_address_id');
        if (!$order->save()) {
            $str = \app\components\GeneralHelper::getErrorAsString($order);
            exit($str);
        }



        $profile = \app\models\Userprofile::findOne(['user_id' => Yii::$app->user->id]);
        $bill = \app\models\OrderAddress::findOne(['order_id' => $order->id, 'address_type' => 2]);
        if (!$bill) {
            $bill = new \app\models\OrderAddress;
        }
        $address = \app\models\ShippingAddress::findOne(['id' => Yii::$app->session->get('bill_address_id')]);

        $bill->order_id = $order->id;
        $bill->contact_person = $profile->fullname;
        $bill->address_1 = $address->address_line1;
        $bill->address_2 = $address->address_line2;
        $bill->city = $address->city;
        $bill->state = $address->state;
        $bill->country = $address->country;
        $bill->postcode = (string) $address->postcode;
        $bill->contact_no = $address->contact_no;
        $bill->address_type = 2;
        if (!$bill->save()) {
            $str = \app\components\GeneralHelper::getErrorAsString($bill);
            exit($str);
        }

        $address = \app\models\ShippingAddress::findOne(['id' => Yii::$app->session->get('ship_address_id')]);
        $ship = \app\models\OrderAddress::findOne(['order_id' => $order->id, 'address_type' => 1]);
        if (!$ship) {
            $ship = new \app\models\OrderAddress;
        }
        $ship->order_id = $order->id;
        $ship->contact_person = $profile->fullname;
        $ship->address_1 = $address->address_line1;
        $ship->address_2 = $address->address_line2;
        $ship->city = $address->city;
        $ship->state = $address->state;
        $ship->country = $address->country;
        $ship->postcode = (string) $address->postcode;
        $ship->contact_no = $address->contact_no;
        $ship->address_type = 1;
        if (!$ship->save()) {
            $str = \app\components\GeneralHelper::getErrorAsString($ship);
            exit($str);
        }

       
        $pc = \app\models\PaymentContext::findOne(['order_id' => $order->id]);
        if (!$pc) {
            $pc = new \app\models\PaymentContext ();
        }
        $pc->user_id = Yii::$app->user->id;
        $pc->payment_mode = $payment_mode;
        $pc->item_total = $order->items_total;
        $pc->shipping = $order->shipping;
        $pc->order_id = $order->id;
        $pc->payment_date = date('Y-m-d H:i');
        if ($payment_mode == 'bank') {
            $pc->gateway_response = Yii::$app->request->post('bank_detail');
        } else {
            $pc->gateway_response = '';
        }
        $pc->payment_status = 1;

        if (!$pc->save()) {
            $str = \app\components\GeneralHelper::getErrorAsString($pc);
            exit($str);
        }
        // remove address id from session
        \Yii::$app->session->remove('ship_address_id');
        \Yii::$app->session->remove('bill_address_id');
        // empty cart
        //\Yii::$app->db->createCommand('DELETE FROM cart where user_id=' . \Yii::$app->user->id)->execute();
        return ['orderId' => $order->id, 'ctxId' => $pc->id];
    }

    public function saveCard($params) {
        $card = new \PayPal\Api\CreditCard();
        $card->setType($params['type']);
        $card->setNumber($params['number']);
        $card->setExpireMonth($params['expire_month']);
        $card->setExpireYear($params['expire_year']);
        $card->setCvv2($params['cvv2']);
        $card->create(self::getApiContext());
        return $card->getId();
    }

    function getApiContext() {
        $clientId = Yii::$app->params['settings']['paypal_client_id'];
        $clientSecret = Yii::$app->params['settings']['paypal_client_secret'];
        $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                $clientId, $clientSecret
                )
        );

        // Comment this line out and uncomment the PP_CONFIG_PATH
        // 'define' block if you want to use static file
        // based configuration

        $apiContext->setConfig(
                array(
                    'mode' => 'sandbox',
                    'log.LogEnabled' => true,
                    'log.FileName' => '../PayPal.log',
                    'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                    'cache.enabled' => true,
                    'http.CURLOPT_CONNECTTIMEOUT' => 30
                // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
                //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
                )
        );

        // Partner Attribution Id
        // Use this header if you are a PayPal partner. Specify a unique BN Code to receive revenue attribution.
        // To learn more or to request a BN Code, contact your Partner Manager or visit the PayPal Partner Portal
        // $apiContext->addRequestHeader('PayPal-Partner-Attribution-Id', '123123123');

        return $apiContext;
    }

    // order items total
    public static function getOrderItemsTotal($orderId) {
        return Yii::$app->db->createCommand("SELECT SUM(price * qty) FROM order_detail WHERE order_id = $orderId")->queryScalar();
    }

    // order amount before discount
    public static function getOrderTotal($orderId) {
        $order = \app\models\Order::findOne(['id' => $orderId]);
        $orderItemsTotal = self::getOrderItemsTotal($orderId);
        $shipping = self::getShippingPrice($order->shipping_address_id);
        return $orderItemsTotal + $shipping;
    }
    
    // order amount after discount
    public static function getAdjustedOrderTotal($orderId) {
        $order = \app\models\Order::findOne(['id' => $orderId]);
        $orderItemsTotal = self::getOrderItemsTotal($orderId);
        $total = 0.00;
        $shipping = self::getShippingPrice($order->shipping_address_id);
        if($order->discount_code!=''){
            $discount = \app\models\Discount::findOne(['discount_code' => $order->discount_code]);
            switch($order->discount_type){
                case '1':
                    $total = $orderItemsTotal - $discount->discount_value;
                    break;
                case '2':
                    $total = $orderItemsTotal - (($orderItemsTotal * $discount->discount_value) / 100);
                    break;
                case '3':
                    $total = $orderItemsTotal;
                    $shipping = 0.00;
                    break;
            }
        } else {
            $total= $orderItemsTotal;
        }
        if($total <= 0){
            $total = 0.00;
        }
        $order->final_order_amount = $total + $shipping;
        $order->save();
        return $total + $shipping;
    }
    
    public static function getFinalOrderTotal($orderId){
        $order = \app\models\Order::findOne(['id' => $orderId]);
        $couponDisplay = '';
        if($order->discount_code!=''){            
            switch($order->discount_type){
                case '1':
                    $couponDisplay = "Flat ".\app\components\ProductHelper::showAmt($order->discount_value)." Off";
                    break;
                case '2':
                    $couponDisplay = $order->discount_value."% Off";
                    break;
                case '3':
                    $couponDisplay = "Shipping Free";
                    break;
                
            } 
        }
        return $arr = [
            'orderItemTotal' => self::getOrderItemsTotal($orderId),
            'shipping' => self::getShippingPrice($order->shipping_address_id),
            'coupon' => $order->discount_code,
            'couponDisplay' => $couponDisplay,
            'isShippingFree' => $order->discount_type == 3 ? true : false,
            'finalAmt' => self::getAdjustedOrderTotal($orderId)            
        ];
    }

    public static function getOrderItems($orderId) {
        $orderItems = [];
        $od = \app\models\OrderDetail::findAll(['order_id' => $orderId]);
        if ($od) {
            foreach ($od as $row) {
                $orderItems[] = [
                    'name' => $row->p->title,
                    'price' => $row->price,
                    'quantity' => $row->qty,
                    'currency' => Yii::$app->params['settings']['paypal_currency']
                ];
            }
        }
        return $orderItems;
    }

    public static function applyDiscount($code) {
        $discount = \app\models\Discount::findOne(['discount_code' => $code]);
        $orderId = Yii::$app->session->get('orderId', NULL);
        //exit(date('Y-m-d',strtotime($discount->expire_date)) < date('Y-m-d'));//
        if ($discount) {
            if ($discount->status == 0 || date('Y-m-d', strtotime($discount->expire_date)) < date('Y-m-d')) { // if coupon is expired
                Yii::$app->session->setFlash('danger', 'Coupon expired');
                return;
            } else {
                // all conditions satisfied, apply coupon
                //exit("Here, applied coupon");
                $order = \app\models\Order::findOne(['id' => $orderId]);
                if (!$order) {
                    Yii::$app->session->setFlash('danger', 'Order does not exists');
                    return;
                } else {
                    $order->discount_code = $code;
                    $order->discount_type = $discount->discount_type;
                    $order->discount_value = $discount->discount_value;
                    $order->final_order_amount = self::getAdjustedOrderTotal($orderId);
                    
                    
                    if($order->save()){
                        Yii::$app->session->setFlash('success', 'Coupon applied');
                    } else {
                        Yii::$app->session->setFlash('danger', 'Error at applying coupon');
                    }
                    return;
                }
            }
        } else { // if coupon code is invalid
            Yii::$app->session->setFlash('danger', 'Invalid coupon code');
        }
    }

    public static function addToCart($alias, $qty) {
        $product = \app\models\Product::findOne(['alias' => $alias]);
        $orderId = Yii::$app->session->get('orderId', false);
        if (!$orderId) {
            $order = new \app\models\Order();
            $order->items_total = 0.00;
            $order->user_id = NULL;
            $order->status = 1;
            if (!$order->save()) {                
                return false;
            } else {
                Yii::$app->session->set('orderId', $order->id);
                 $orderItem = new \app\models\OrderDetail();
                $orderItem->qty = $qty;
                $orderItem->order_id = $order->id;
                $orderItem->pid = $product->id;
                $orderItem->price = $product->price;
                $orderItem->save();
                return true;
            }
        } else {
            $orderItem = \app\models\OrderDetail::findOne(['order_id' => $orderId, 'pid' => $product->id]);
            if (!$orderItem) {
                $orderItem = new \app\models\OrderDetail();
                $orderItem->qty = $qty;
                $orderItem->order_id = $orderId;
                $orderItem->pid = $product->id;
                $orderItem->price = $product->price;
            } else {
                $orderItem->qty += $qty;
            }


            if (!$orderItem->save()) {
                return false;
            } else {
                return true;
            }
        }
    }
    
    public static function resetOrder(){
        Yii::$app->session->remove("orderId");        
    }

}

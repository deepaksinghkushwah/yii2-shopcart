<?php

namespace app\modules\store\controllers;

use Yii;

class PaypalController extends \yii\web\Controller {

   

    public function actionSuccess() {
        //\Yii::$app->db->createCommand('DELETE FROM cart where user_id=' . \Yii::$app->user->id)->execute();
        return $this->render('success',['orderId'=> Yii::$app->session->get('order_id')]);
    }

    public function actionCancel() {
        return $this->render('cancel',['orderId'=> Yii::$app->session->get('order_id')]);
    }

    

    public function beforeAction($action) {
        //if (Yii::$app->controller->action->id == "ipn" || Yii::$app->controller->action->id == "success" || Yii::$app->controller->action->id == "cancel"){
        $this->enableCsrfValidation = false;
        //}
        return parent::beforeAction($action);
    }

    
    public function actionRestCheckoutStep1() {
        // Setup order information array with all items
        $orderId = Yii::$app->request->get('order_id');
        $ctxId = Yii::$app->request->get('ctx_id');        
        Yii::$app->session->set('ctxId', $ctxId);
        $order = \app\models\Order::findOne(['id' => $orderId]);
        $params = [
            'method' => 'paypal',            
            'intent' => 'sale',
            'order' => [
                'description' => 'Items purchased on ' . Yii::$app->name,
                'subtotal' => \app\modules\store\components\StoreHelper::getAdjustedOrderTotal($orderId),                
                'total' => \app\modules\store\components\StoreHelper::getAdjustedOrderTotal($orderId),
                'currency' => Yii::$app->params['settings']['paypal_currency'],
                'shippingCost' => 0.00,
                //'items' => \app\modules\store\components\StoreHelper::getOrderItems($orderId)
                'items' => [['name' => 'Products From '.Yii::$app->name.' - Order ID: '.Yii::$app->session->get('orderId'),
                    'price' => \app\modules\store\components\StoreHelper::getAdjustedOrderTotal($orderId),
                    'quantity' =>1,
                    'currency' => Yii::$app->params['settings']['paypal_currency']]
            ]]
        ];
        
        if(!empty($order->discount_code)){
            if($order->discount_type == 3){
                $params['order']['shipping_discount'] = $order->shipping;
            } else {
                $params['order']['discount'] = ($order->items_total - $order->final_order_amount);
            }
            
            
        }

        // In this action you will redirect to the PayPpal website to login with you buyer account and complete the payment
        Yii::$app->PayPalRestApi->checkOut($params);
    }

    public function actionMakePayment() {
        // Setup order information array 
        $orderId = Yii::$app->session->get('orderId');
        $ctxId = Yii::$app->session->get('ctxId');        
        $order = \app\models\Order::findOne(['id' => $orderId]);
        $params = [            
            'order' => [
                'shippingCost' => 0.00,
                'description' => 'Payment description',
                'subtotal' => \app\modules\store\components\StoreHelper::getAdjustedOrderTotal($orderId),                
                'total' => \app\modules\store\components\StoreHelper::getAdjustedOrderTotal($orderId),
                'currency' => Yii::$app->params['settings']['paypal_currency'],
            ]
        ];
        
        // In case of payment success this will return the payment object that contains all information about the order
        // In case of failure it will return Null
        $response = Yii::$app->PayPalRestApi->processPayment($params);
        
        $pc = \app\models\PaymentContext::findOne(['order_id' => $order->id]);
        //exit("Here".Yii::$app->session->get('ctxId'));
        $pc->gateway_response = \yii\helpers\Json::encode($_REQUEST);
        $pc->save();
        
        $data = \yii\helpers\Json::decode($pc->gateway_response,true);        
        
        if($response && $response->getState() == 'approved'){
            $pc->payment_status = 2;
            $pc->save();
            $order->status = 2;
            $order->save();
            
           // Yii::$app->db->createCommand("DELETE FROM cart WHERE session_id = '" .Yii::$app->session->id. "'")->execute();
            $stat =1;
        } else {           
            $stat = 0;
        }
        if($stat == 1){
            //exit("Here successs");
            \app\modules\store\components\StoreHelper::resetOrder();
            return $this->redirect(\yii\helpers\Url::to(['/store/paypal/success']));
        } else {
            //exit("Here failed");
            return $this->redirect(\yii\helpers\Url::to(['/store/paypal/cancel']));
        }
        
        
    }

}

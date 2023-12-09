<?php

namespace app\modules\backend\controllers;

use yii;

class OrderController extends \yii\web\Controller {

    public function actionIndex() {
        $query = \app\models\Order::find();


        $query->where = "user_id > 0";

        $query->orderBy = ['id' => SORT_DESC];
        $model = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => \app\models\Setting::findOne(['key' => 'record_per_page'])->value,
            ],
        ]);
        return $this->render('index', ['model' => $model]);
    }

    public function actionOrderDetail() {
        $id = Yii::$app->request->get('id');
        $order = \app\models\Order::findOne(['id' => $id]);
        $od = \app\models\OrderDetail::findAll([
                    'order_id' => $id
        ]);
        return $this->renderAjax('order-detail', [
                    'order' => $order,
                    'model' => $od
        ]);
        //return $this->renderAjax('order-detail', ['model' => $od]);
    }

    public function actionUpdateOrder() {
        $id = \Yii::$app->request->post('id');
        $status = \Yii::$app->request->post('status');
        $order = \app\models\Order::findOne(['id' => $id]);
        $order->status = $status;
        if ($order->update()) {
            if ($status == 2) { // if status is changed to paid
                $pc = \app\models\PaymentContext::findOne(['order_id' => $id]);
                if (!$pc) {
                    $pc = new \app\models\PaymentContext();
                }
                //$pc->payment_mode = 'admin approved';
                $pc->order_id = $id;
                $pc->item_total = $order->items_total;
                $pc->shipping = $order->shipping;
                $pc->user_id = $order->user_id;
                $pc->payment_date = date('Y-m-d H:i');
                $pc->payment_status = 2;
                $pc->save();
            } elseif ($status == 1) {
                $pc = \app\models\PaymentContext::findOne(['order_id' => $id]);
                if (!$pc) {
                    $pc = new \app\models\PaymentContext();
                }
                
                //$pc->payment_mode = 'admin approved';
                $pc->order_id = $id;
                $pc->item_total = $order->items_total;
                $pc->shipping = $order->shipping;
                $pc->user_id = $order->user_id;
                $pc->payment_date = date('Y-m-d H:i');
                $pc->payment_status = 1;
                $pc->save();
            } else {
                // do nothing right now
            }
            echo json_encode(['msg' => 'Status updated successfully']);
        } else {
            echo json_encode(['msg' => 'Error occur while updating status, please try again']);
        }
        \Yii::$app->end();
    }

    public function actionInvoice() {
        
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $this->layout = "empty";
        $orderId = Yii::$app->request->get('id');
        
        $order = \app\models\Order::findOne(['id' => $orderId]);
        $content = \app\components\InvoiceWidget::widget(['orderId' => $orderId], true);        
        $pdf = Yii::$app->pdf;
        $pdf->cssFile = Yii::getAlias("@themes").'/frame/views/files/css/bootstrap-theme.css';
        $pdf->getCss();
        $pdf->content = $content;
        return $pdf->render();
    }

}

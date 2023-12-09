<?php

namespace app\modules\store\controllers;

use yii\web\Controller;
use Yii;
use app\models\ProductReview;
use app\models\Wishlist;
use yii\helpers\Url;
use \app\components\GeneralHelper;

/**
 * Default controller for the `store` module
 */
class CatalogController extends Controller {

    public function actionIndex() {
        $cat_id = Yii::$app->request->get('cat_id', 0);
        $q = Yii::$app->request->get('q', '');
        $query = \app\models\Product::find();
        $search = "id > 0";
        if (!empty($q)) {
            $search .= (" AND title like '%$q%'");
        }

        if ($cat_id != 0) {
            $search .= ' AND cat_id = ' . $cat_id;
        }
        $query->where($search);
        $query->orderBy = ['id' => SORT_DESC];

        $products = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => \app\models\Setting::findOne([
                    'key' => 'record_per_page'
                ])->value
            ]
        ]);
        return $this->render('index', [
                    'cat_id' => $cat_id,
                    'products' => $products,
                    'q' => $q
        ]);
    }

    public function actionProductDetail($alias) {
        //$alias = Yii::$app->request->get('alias');
        //var_dump($alias);exit;

        //$cart = new \app\models\Cart ();
        $model = \app\models\Product::findOne([
                    'alias' => $alias
        ]);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException("Requested product not found");
        }

        if ($model->status == '0') {
            Yii::$app->getSession()->setFlash('danger', 'Item is not available right now!');
            return $this->goHome();
        }

        

        return $this->render('detail', [
                    'model' => $model,
                    //'cart' => $cart
        ]);
    }

    public function actionCart() {
        $model = \app\models\OrderDetail::findAll([
                    'order_id' => Yii::$app->session->get('orderId')
        ]);
        return $this->render('cart', [
                    'model' => $model
        ]);
    }

    public function actionRemoveitemfromcart() {
        $id = Yii::$app->request->get('id', 0);
        \app\models\OrderDetail::findOne([
            'id' => $id
        ])->delete();
        \Yii::$app->session->setFlash('success', 'Item removed from your cart.');
        return $this->redirect(Url::to(['/store/catalog/cart'],true));
    }

    public function actionCheckoutStep1() {
        $model = \app\models\ShippingAddress::findAll([
                    'user_id' => Yii::$app->user->id
        ]);
        return $this->render('checkout-step1', [
                    'model' => $model
        ]);
    }

    public function actionAddShippingAddress() {
        $model = new \app\models\ShippingAddress ();
        $model->user_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', 'Address Saved');
                echo "<script>parent.location.reload(true);</script>";
                exit();
            } else {
                \Yii::$app->session->setFlash('danger', 'Error at saving address');
            }
        }
        return $this->renderAjax('shipping-address-form', [
                    'model' => $model
        ]);
    }

    public function actionCheckoutStep2() {
        $ship_address_id = \Yii::$app->request->post('ship_address_id', 0);
        $bill_address_id = \Yii::$app->request->post('bill_address_id', 0);

        // save address id to session for future use
        \Yii::$app->session->set('ship_address_id', $ship_address_id);
        \Yii::$app->session->set('bill_address_id', $bill_address_id);

        // get cart content
        $model = \app\models\OrderDetail::findAll([
                    'order_id' => Yii::$app->session->get('orderId')
        ]);
        if (!$model) {
            \Yii::$app->session->setFlash('danger', 'No item in your cart to checkout!');
            return $this->redirect(\Yii::$app->homeUrl);
        }

        // get shipping price from helper
        $shipping_price = \app\modules\store\components\StoreHelper::getShippingPrice($ship_address_id);
        return $this->render('checkout-step2', [
                    'model' => $model,
                    'shipping_price' => $shipping_price
        ]);
    }

    public function actionPlaceOrder() {
        $status = \app\modules\store\components\StoreHelper::preConfirmOrder();
        $ctxId = $status['ctxId'];
        $orderId = $status['orderId'];
        $payment_mode = Yii::$app->request->post('payment_mode', 'bank');
        switch ($payment_mode) {
            /* case 'paypal':
              return $this->redirect(yii\helpers\Url::to(['/store/paypal/index', 'ctxid' => $ctxId], true));
              break; */
            case 'paypal_rest_api':
                return $this->redirect(['/store/paypal/rest-checkout-step1', 'order_id' => $orderId, 'ctx_id' => $ctxId]);
                break;
            case 'bank':
                
                \app\modules\store\components\StoreHelper::sendOrderConfirmMail($orderId);
                \app\modules\store\components\StoreHelper::resetOrder();
                return $this->redirect(yii\helpers\Url::to(['/store/bank/index', 'ctxid' => $ctxId], true));
                break;
        }
    }

    public function actionOrderHistory() {
        $query = \app\models\Order::find();

        $query->where = [
            'user_id' => Yii::$app->user->id
        ];

        $query->orderBy = [
            'id' => SORT_DESC
        ];
        $model = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => \app\models\Setting::findOne([
                    'key' => 'record_per_page'
                ])->value
            ]
        ]);
        return $this->render('order-history', [
                    'model' => $model
        ]);
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
    }

    public function actionAddtowishlist() {
        $id = Yii::$app->request->get('id');

        if (\app\models\Wishlist::findOne([
                    'user_id' => Yii::$app->user->id,
                    'product_id' => $id
                ])) {
            Yii::$app->getSession()->setFlash("warning", 'Item already in your wishlist');
        } else {
            $w = new \app\models\Wishlist ();
            $w->user_id = Yii::$app->user->id;
            $w->created_at = date('Y-m-d H:i');
            $w->product_id = $id;
            $w->save();
            Yii::$app->getSession()->setFlash("success", 'Item added to your wishlist');
        }
        $this->redirect($_SERVER ['HTTP_REFERER']);
    }

    public function actionRemovewishlistitem() {
        $id = Yii::$app->request->get('id');
        $list = Wishlist::findOne([
                    'id' => $id,
                    'user_id' => Yii::$app->user->id
        ]);

        if ($list) {
            $list->delete();
            Yii::$app->getSession()->setFlash("success", 'Item removed from wishlist');
        } else {
            Yii::$app->getSession()->setFlash("danger", 'You are not authorized to perform this action.');
        }



        $this->redirect(Url::to(['/shop/wishlist'], true));
    }

    public function actionWishlist() {
        $query = \app\models\Wishlist::find();

        $query->where = [
            'user_id' => Yii::$app->user->id
        ];

        $query->orderBy = [
            'id' => SORT_DESC
        ];
        $model = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => \app\models\Setting::findOne([
                    'key' => 'record_per_page'
                ])->value
            ]
        ]);
        return $this->render('wishlist', [
                    'model' => $model
        ]);
    }

    public function actionGetstate() {
        $id = Yii::$app->request->get('id');
        $model = \app\models\States::findAll([
                    'country_id' => $id
        ]);
        $ret = [];
        if ($model) {
            foreach ($model as $row) {
                $ret [] = [
                    'id' => $row->id,
                    'name' => $row->name
                ];
            }
            echo json_encode([
                'records' => $ret,
                'status' => 0
            ]);
        } else {
            echo json_encode([
                'records' => $ret,
                'status' => 1
            ]);
        }
        Yii::$app->end();
    }

    public function actionGetcity() {
        $id = Yii::$app->request->get('id');
        $model = \app\models\Cities::findAll([
                    'state_id' => $id
        ]);
        $ret = [];
        if ($model) {
            foreach ($model as $row) {
                $ret [] = [
                    'id' => $row->id,
                    'name' => $row->name
                ];
            }
            return json_encode([
                'records' => $ret,
                'status' => 0
            ]);
        } else {
            return json_encode([
                'records' => $ret,
                'status' => 1
            ]);
        }
    }

    /**
     * Review related functions
     */
    public function actionAddreview() {
        $pid = Yii::$app->request->get('pid');
        $model = ProductReview::findOne([
                    'user_id' => Yii::$app->user->id,
                    'product_id' => $pid
        ]);
        if (!$model) {
            $model = new ProductReview ();
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = isset(Yii::$app->user->id) ? Yii::$app->user->id : 0;
            $model->created_at = date('Y-m-d H:i');
            $model->parent_id = 0;
            if ($model->save()) {
                echo 'Review added, thank you for your time.';
            } else {
                $errors = $model->getErrors();
                echo "<pre>";
                print_r($errors);
                echo "</pre>";
            }
        }

        return $this->renderAjax('review-form', [
                    'model' => $model,
                    'pid' => $pid
        ]);
    }

    public function actionDownloadInvoice() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $this->layout = "empty";
        $orderId = Yii::$app->request->get('id');

        $order = \app\models\Order::findOne(['id' => $orderId]);
        $content = \app\components\InvoiceWidget::widget(['orderId' => $orderId], true);
        $pdf = Yii::$app->pdf;
        $pdf->cssFile = Yii::getAlias("@themes") . '/frame/views/files/css/bootstrap-theme.css';
        $pdf->getCss();
        $pdf->content = $content;
        return $pdf->render();
    }
    
    public function actionApplyCoupon(){
        $code = Yii::$app->request->get('code');
        \app\modules\store\components\StoreHelper::applyDiscount($code);
        return $this->redirect(Url::to(['/store/catalog/cart'],true));
    }
    
    public function actionAddToCart(){
        $alias = Yii::$app->request->post('alias');
        $qty = Yii::$app->request->post('qty');
        $res = \app\modules\store\components\StoreHelper::addToCart($alias, $qty);        
        if($res){
            Yii::$app->session->setFlash('success','Item added to cart');
        } else {
            Yii::$app->session->setFlash('danger','Unable to add item to cart');
        }
        return $this->redirect(Url::to(['/store/catalog/cart'],true));
    }
    
    public function actionLoadOrder(){
        $orderId = Yii::$app->request->get('order_id');
        Yii::$app->session->set('orderId',$orderId);
        return $this->redirect(Url::to(['/store/catalog/cart'],true));
    }

}

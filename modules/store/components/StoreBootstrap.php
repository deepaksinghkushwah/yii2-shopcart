<?php

namespace app\modules\store\components;
use \yii\base\BootstrapInterface;
class StoreBootstrap implements BootstrapInterface {

    public function bootstrap($app) {
        $app->getUrlManager()->addRules([
            /*'store/<controller:\w+>/<action:\w+>/<id:(.*?)>' => 'store/<controller>/<action>/<id>',
            'store/<controller:\w+>/<action:\w+>' => 'store/<controller>/<action>',
            'store/<action:\w+>/<id:(.*?)>' => 'store/default/<action>/<id>',
            'store/index' => 'store/default/index',
            'store' => 'store/default/index',
            'store/product-detail/<alias>' => 'store/default/product-detail',
            'store/checkout-step1' => 'store/default/checkout-step1',
            'store/checkout-step2' => 'store/default/checkout-step2',
            'store/cart' => 'store/default/cart',
            'store/removeitemfromcart' => 'store/default/removeitemfromcart',
            
            'store/add-shipping-address' => 'store/default/add-shipping-address',
            'store/place-order' => 'store/default/place-order',
            'store/order-history' => 'store/default/order-history',
            'store/order-detail' => 'store/default/order-detail',
            'store/addtowishlist' => 'store/default/addtowishlist',
            'store/removewishlistitem' => 'store/default/removewishlistitem',
            'store/wishlist' => 'store/default/wishlist',
            'store/state' => 'store/default/state',
            'store/city' => 'store/default/city',
            'store/addreview' => 'store/default/addreview',*/
            
            'store/catalog/product-detail/<alias>' => 'store/catalog/product-detail',
                ], false);
    }

}

<?php

namespace app\modules\store\components;

class StoreGlobals {
    public static $orderStatus = ['1' => 'Order Placed', '2' => 'Paid', '3' => 'In Process', '4' => 'Shipped', '5' => 'Completed'];
    public static $paymentStatus = ['1' => 'Unpaid', '2' => 'Paid'];

}

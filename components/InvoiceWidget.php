<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class InvoiceWidget extends Widget
{
    public $orderId;

    public function init()
    {
        parent::init();
        
    }

    public function run()
    {
        $order = \app\models\Order::findOne(['id' => $this->orderId]);        
        return $this->render("invoice",['order' => $order]);
    }
}
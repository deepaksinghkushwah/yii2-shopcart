<?php

namespace app\modules\store;

use Yii;

/**
 * store module definition class
 */
class Store extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\store\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        /* $this->layoutPath = \Yii::getAlias('@themes/admin/views/layouts/');
          $this->layout = 'main'; */

        // custom initialization code goes here
        //Yii::configure($this, require(__DIR__ . '/config/paypal.php'));
    }

}

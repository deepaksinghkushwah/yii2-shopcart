<?php
namespace app\modules\store\components;

use yii\base\Widget;
use yii\helpers\Html;

class SearchWidget extends Widget
{
    public $q;

    public function init()
    {
        parent::init();
        
    }

    public function run()
    {        
        return $this->render("search");
    }
}
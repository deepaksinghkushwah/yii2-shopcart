<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Discount */

$this->title = 'Update Discount: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Discounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="discount-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

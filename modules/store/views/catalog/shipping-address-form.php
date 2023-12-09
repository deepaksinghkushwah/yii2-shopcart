<?php
\app\assets\FrameAsset::register($this);
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/store/shipping-address-form.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
?>
<h1>Add Shipping Address</h1>

<?php

$form = \yii\widgets\ActiveForm::begin([
            'id' => 'shipping-address'
        ]);
echo \yii\helpers\Html::hiddenInput('getStateUrl',  yii\helpers\Url::to(['/store/catalog/getstate'],true),['id' => 'getStateUrl']);
echo \yii\helpers\Html::hiddenInput('getCityUrl',  yii\helpers\Url::to(['/store/catalog/getcity'],true),['id' => 'getCityUrl']);
?>
<?= $form->field($model, 'contact_person'); ?>
<?= $form->field($model, 'contact_no'); ?>
<?= $form->field($model, 'address_line1'); ?>
<?= $form->field($model, 'address_line2'); ?>
<?= $form->field($model, 'country')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Countries::find()->all(),'id','name'),['prompt' => 'Select Country']); ?>
<?= $form->field($model, 'state')->dropDownList([],['prompt' => 'Select State']); ?>
<?= $form->field($model, 'city')->dropDownList([],['prompt' => 'Select City']); ?>
<?= $form->field($model, 'postcode'); ?>
<?= yii\helpers\Html::submitButton('Add Address', ['class' => 'btn btn-primary']); ?>

<?php
\yii\widgets\ActiveForm::end();

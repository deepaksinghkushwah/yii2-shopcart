<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/frontend/signup.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
echo Html::hiddenInput("getCountyUrl", yii\helpers\Url::to(['/site/get-counties'], true), ['id' => 'getCountyUrl']);
echo Html::hiddenInput("getCityUrl", yii\helpers\Url::to(['/site/get-cities'], true), ['id' => 'getCityUrl']);

if ($profile->isNewRecord) {
    $country = yii\helpers\ArrayHelper::map(\app\models\GeoCountry::find()->all(), 'id', 'name');
    $states = [];
    $cities = [];
} else {
    $country = yii\helpers\ArrayHelper::map(\app\models\GeoCountry::find()->all(), 'id', 'name');
    $states = yii\helpers\ArrayHelper::map(\app\models\GeoState::find()->where("country_id = '" . $profile->country . "'")->all(), 'id', 'name');
    $cities = yii\helpers\ArrayHelper::map(\app\models\GeoCity::find()->where("state_id = '" . $profile->county . "'")->all(), 'id', 'name');
}
?>

<div class="user-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'signup-create-form',
                'options' => ['enctype' => 'multipart/form-data'],
                'fieldConfig' => [
                    'template' => "<div class='row'>"
                    . "<div class='col-lg-2'>"
                    . "{label}"
                    . "</div>"
                    . "<div class='col-lg-10'>"
                    . "{input}{error}"
                    . "</div>"
                    . "</div>",
                ]
    ]);
    ?>

    <?= $form->errorSummary([$model, $profile]); ?>



    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'email') ?>        
    <?php if ($profile->isNewRecord) { ?>
        <?= $form->field($model, 'password')->passwordInput(); ?>        
    <?php } ?>
    <?= $form->field($profile, 'fullname')->textInput() ?>
    <?= $form->field($profile, 'contact_mobile')->textInput() ?>
    <?= $form->field($profile, 'address_line1')->textInput() ?>
    <?= $form->field($profile, 'country')->dropDownList($country, ['prompt' => 'Select Any']) ?>
    <?= $form->field($profile, 'county')->dropDownList($states, ['prompt' => 'Select Any']) ?>
    <?= $form->field($profile, 'city')->dropDownList($cities, ['prompt' => 'Select Any']) ?>
    <?= $form->field($profile, 'postcode')->textInput() ?>

    <?= $form->field($profile, 'image')->fileInput(['class' => 'form-control']) ?>
    <?php
    if ($profile && $profile->image != '') {
        echo "<div class='row'><div class='col-lg-2'></div><div class='col-lg-10'>";
        echo Html::img(\yii\helpers\Url::to(['/images/profile/' . $profile->image], true), ['class' => 'img-thumbnail', 'width' => 100]) . '<br/><br/>';
        echo "</div></div>";
    }
    ?>
    <div class="form-group">
        <?= "<div class='row'><div class='col-lg-2'></div><div class='col-lg-10'>"; ?>
        <?= Html::submitButton($profile->isNewRecord ? 'Create' : 'Update', ['class' => $profile->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::button('Cancel', ['class' => 'btn btn-danger', 'onclick' => 'window.location.href="' . \yii\helpers\Url::to(['/backend/user/index'], true) . '"']) ?>
        <?= "</div></div>"; ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userprofile */
/* @var $form yii\widgets\ActiveForm */

$country = yii\helpers\ArrayHelper::map(\app\models\GeoCountry::find()->all(),'id','name');
$states = yii\helpers\ArrayHelper::map(\app\models\GeoState::find()->where("country_id = '".$model->country."'")->all(),'id','name');
$cities = yii\helpers\ArrayHelper::map(\app\models\GeoCity::find()->where("state_id = '".$model->county."'")->all(),'id','name');

$this->registerJsFile(yii\helpers\Url::to('/js/frontend/signup.js'), ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
echo Html::hiddenInput("getCountyUrl", yii\helpers\Url::to(['/site/get-counties'],true),['id' => 'getCountyUrl']);
echo Html::hiddenInput("getCityUrl", yii\helpers\Url::to(['/site/get-cities'],true),['id' => 'getCityUrl']);
?>

<div class="userprofile-form">

    <?php
    $form = ActiveForm::begin([
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
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_line1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->dropDownList($country, ['prompt' => 'Select Any']) ?>
    <?= $form->field($model, 'county')->dropDownList($states, ['prompt' => 'Select Any']) ?>
    <?= $form->field($model, 'city')->dropDownList($cities, ['prompt' => 'Select Any']) ?>
    <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'image')->fileInput(['class' => 'form-control']) ?>
    <?php
    if ($model && $model->image != '') {
        echo "<div class='row'><div class='col-lg-2'></div><div class='col-lg-10'>";
        echo Html::img(\yii\helpers\Url::to(['/images/profile/' . $model->image], true), ['class' => 'img-thumbnail', 'width' => 100]) . '<br/><br/>';
        echo "</div></div>";
    }
    ?>

    <div class="form-group">
        <?= "<div class='row'><div class='col-lg-2'></div><div class='col-lg-10'>"; ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= "</div></div>"; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

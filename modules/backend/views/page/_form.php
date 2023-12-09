<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/jqte/jquery-te-1.4.0.css');
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/jqte/jquery-te-1.4.0.min.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs('$("textarea").jqte();');
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status'], ['prompt' => 'Select Any']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

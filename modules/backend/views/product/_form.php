<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?=$form->errorSummary($model);?>

    <?= $form->field($model, 'cat_id')->dropDownList(yii\helpers\ArrayHelper::map((new \app\components\CategoryHelper)->fetchCategoryTree(0,[],'|-'), 'id', 'cat_name')); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status'], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a href="<?= \yii\helpers\Url::to(['/backend/product/index'],true)?>" class="btn btn-danger">Cancel</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>

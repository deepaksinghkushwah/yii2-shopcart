<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Discount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discount-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount_type')->dropDownList(Yii::$app->params['discountTypes']) ?>

    <?= $form->field($model, 'discount_value')->textInput() ?>

    <?=
    $form->field($model, 'expire_date')->widget(\yii\jui\DatePicker::class, [
        //'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control']
    ])
    ?>

    

        <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status']) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <a href="<?= yii\helpers\Url::to(['/backend/discount/index'],true)?>" class="btn btn-danger">Cancel</a>
    </div>

<?php ActiveForm::end(); ?>

</div>

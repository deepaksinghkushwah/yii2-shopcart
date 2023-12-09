<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
$tree = (new \app\components\CategoryHelper)->fetchCategoryTree(0, [], '|-');
//echo "<pre>";print_r($tree);echo "</pre>";
array_unshift($tree, ['id' => '', 'cat_name' => 'All Categories']);
?>

<div class="product-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'fieldConfig' => [
                    'template' => '{input}'
                ],
                'method' => 'get',
    ]);
    ?>
    <table class="table table-borderless">
        <tr>
            <th>#</th>
            <th>Category</th>
            <th>Title</th>
            <th>Featured</th>
            <th>Status</th>
            <th width="200"></th>
        </tr>
        <tr>
            <td><?= $form->field($model, 'id') ?></td>
            <td><?= $form->field($model, 'cat_id')->dropDownList(yii\helpers\ArrayHelper::map($tree, 'id', 'cat_name')); ?></td>
            <td><?= $form->field($model, 'title') ?></td>
            <td><?= $form->field($model, 'featured')->dropDownList(['0' => 'Normal', '1' => 'Featured'],['prompt' => 'Select Any']) ?></td>
            <td><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status'],['prompt' => 'Select Any']) ?></td>
            <td>
                <div class="form-group">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                    <a href="<?= \yii\helpers\Url::to(['/backend/product/index'], true) ?>" class="btn btn-danger">Reset</a>
                </div>

            </td>

        </tr>


    </table>










    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'add_date') ?>

    <?php // echo $form->field($model, 'published') ?>



    <?php ActiveForm::end(); ?>

</div>

<?php
\app\assets\FrameAsset::register($this);
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$form = ActiveForm::begin();
for($i = 1; $i <= 10; $i++){
	$items[$i] = $i;
}
?>
<?php echo $form->field($model, 'product_id',['template' => '{input}'])->hiddenInput(['value' => $pid]);?>
<?php echo $form->field($model, 'title');?>
<?php echo $form->field($model, 'review');?>
<?php echo $form->field($model, 'rating')->radioList($items);?>
<?php echo Html::submitButton("Save",['class' => 'btn btn-primary'])?>

<?php 
ActiveForm::end();
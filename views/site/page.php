<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = $model ? $model->title : 'Contact Us';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?=$model->content;?>

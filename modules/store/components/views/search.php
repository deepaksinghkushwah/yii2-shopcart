<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="well bg-primary">
    <?= yii\helpers\Html::beginForm(\yii\helpers\Url::to([Yii::$app->request->url], true), 'get') ?>
    <div class="row">
        <div class="col-md-9"><input type="text" name="q" placeholder="Search" value="<?=Yii::$app->request->get('q')?>" class="form-control" ></div>
        <div class="col-md-3">
            <input type="submit" value="Search" class="btn btn-primary"> 
            <a href="<?= \yii\helpers\Url::to(['/store/catalog/index'],true)?>" class="btn btn-danger">Reset</a>
        </div>
    </div>


    <?= yii\helpers\Html::endForm() ?>
</div>


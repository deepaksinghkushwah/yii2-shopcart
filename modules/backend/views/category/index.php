<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        /*'filterModel' => $searchModel,*/
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'cat_name',
            'parent_id' => [
                'label' => 'Parent Category',
                'value' => function($model) {
                    return $model->parent_id == 0 ? 'Root' : app\models\Category::findOne(['id' => $model->parent_id])->cat_name;
                },
                    ],
                    'published',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>

</div>

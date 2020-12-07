<?php

use core\entities\Category\Category;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \backend\forms\CategorySearch */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'value' => function (Category $model) {
                    return Html::img($model->getIconPath(), ['width' => 100]);
                },
                'label' => 'Icon',
                'format' => 'raw'
            ],
            [
                'attribute' => 'name',
                'value' => function (Category $model) {
                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                },
                'format' => 'raw'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

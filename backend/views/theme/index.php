<?php

use core\entities\Theme\Theme;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \backend\forms\ThemeSearch */

$this->title = 'Themes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="theme-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Theme', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'value' => function (Theme $model) {
                    return Html::img($model->getImagePath(), ['width' => 100]);
                },
                'label' => 'Image',
                'format' => 'raw'
            ],
            [
                'attribute' => 'name',
                'value' => function (Theme $model) {
                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'category_id',
                'filter' => $searchModel->categoriesList(),
                'value' => function (Theme $theme) {
                    return $theme->category->name;
                },
                'label' => 'Category',
                'format' => 'raw'
            ],
            [
                'attribute' => 'level_id',
                'filter' => $searchModel->levelsList(),
                'value' => function (Theme $theme) {
                    return $theme->level->name;
                },
                'format' => 'raw',
                'label' => 'Level',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

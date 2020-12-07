<?php

use core\entities\Word\Word;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \backend\forms\WordSearch */

$this->title = 'Words';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="word-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Word', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'value' => function (Word $model) {
                    return Html::img($model->getImagePath(), ['width' => 100]);
                },
                'label' => 'Image',
                'format' => 'raw'
            ],
            [
                'attribute' => 'name',
                'value' => function (Word $model) {
                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                },
                'format' => 'raw'
            ],
            'transcription',
            'translation',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

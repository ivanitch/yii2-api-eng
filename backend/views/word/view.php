<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\entities\Word\Word */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="word-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <? if ($model->image):
            echo ' || ';
            echo Html::a('Change Image', ['change-image', 'id' => $model->id], [
                'class' => 'btn btn-warning',
            ]);
            echo ' | ';
            echo Html::a('Delete image', ['delete-image', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post'
                ]
            ]);
        endif; ?>
        <? if ($model->sound):
            echo ' || ';
            echo Html::a('Change Sound', ['change-sound', 'id' => $model->id], [
                'class' => 'btn btn-warning',
            ]);
            echo ' | ';
            echo Html::a('Delete Sound', ['delete-sound', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post'
                ]
            ]);
        endif; ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'translation',
            'transcription',
            'example:ntext',
            [
                'value' => Html::img($model->getImagePath(), ['class' => 'img-responsive']),
                'label' => 'Image',
                'format' => 'raw'
            ],
            [
                'attribute' => 'sound',
                'value' => $model->getSound(),
                'format' => 'raw'
            ]
        ],
    ]) ?>
</div>



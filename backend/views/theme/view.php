<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\entities\Theme\Theme */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="theme-view">

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
        |
        <? if ($model->image):
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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'category_id',
                'label' => 'Category',
                'value' => ArrayHelper::getValue($model, 'category.name'),
            ],
            [
                'attribute' => 'level_id',
                'label' => 'Level',
                'value' => ArrayHelper::getValue($model, 'level.name'),
            ],
            [
                'value' => Html::img($model->getImagePath(), ['class' => 'img-responsive']),
                'label' => 'Image',
                'format' => 'raw'
            ],
        ],
    ]) ?>

</div>


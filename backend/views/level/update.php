<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $level core\entities\Level\Level */
/* @var $model \core\forms\manage\Level\LevelForm */

$this->title = 'Update Level: ' . $level->name;
$this->params['breadcrumbs'][] = ['label' => 'Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $level->name, 'url' => ['view', 'id' => $level->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="level-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

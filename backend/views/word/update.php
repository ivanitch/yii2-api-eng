<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $word core\entities\Word\Word */
/* @var $model \core\forms\manage\Word\WordForm */

$this->title = 'Update Word: ' . $word->name;
$this->params['breadcrumbs'][] = ['label' => 'Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $word->name, 'url' => ['view', 'id' => $word->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="word-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

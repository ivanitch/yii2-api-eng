<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $theme core\entities\Theme\Theme */
/* @var $model \core\forms\manage\Theme\ThemeForm */

$this->title = 'Update Theme: ' . $theme->name;
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $theme->name, 'url' => ['view', 'id' => $theme->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="theme-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

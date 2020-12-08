<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $theme \core\entities\Theme\Theme */
/* @var $model \core\forms\manage\Theme\ThemeForm */

$this->title = $theme->name;
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $theme->name, 'url' => ['view', 'id' => $theme->id]];
\yii\web\YiiAsset::register($this);
?>
<div class="theme-image">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>
    <div class="post-form-image" style="margin-top: 30px">
        <? if ($theme): ?>
            <img src="<?= $theme->getImagePath() ?>" class="img-responsive">
        <? endif; ?>
    </div>
    <?= $form->field($model, 'image')->fileInput(['options' => ['accept' => 'image/*']]) ?>
    <div style="margin-top: 40px">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


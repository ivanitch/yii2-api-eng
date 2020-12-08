<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\Theme\ThemeForm */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="theme-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList($model->categoriesList(), ['prompt' => 'select...']) ?>

    <?= $form->field($model, 'level_id')->dropDownList($model->levelsList(), ['prompt' => 'select...']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model->image, 'image')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

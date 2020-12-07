<?php

use core\entities\Word\Word;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\Word\WordForm */
/* @var $form yii\widgets\ActiveForm */

$id = Yii::$app->request->get('id');
$word = Word::findOne($id);
?>

<div class="word-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'translation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transcription')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'example')->textarea(['rows' => 2]) ?>

    <? if ($word): ?>
    <div style="margin:20px 0;">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= $word->getImagePath() ?>">
            </div>
            <div class="col-md-6">
                <?= $word->getSound() ?>
            </div>
        </div>
    </div>
    <? endif; ?>

    <?= $form->field($model->sound, 'file')->fileInput() ?>

    <?= $form->field($model->image, 'image')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $theme \core\entities\Theme\Theme */
/* @var $model \core\forms\manage\Theme\WordsForm */

$this->title = $theme->name;
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $theme->name, 'url' => ['view']];
\yii\web\YiiAsset::register($this);
?>
<div class="theme-image">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>
    <?= $form->field($model, 'existing')->checkboxList($model->list()) ?>
    <div style="margin-top: 40px">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


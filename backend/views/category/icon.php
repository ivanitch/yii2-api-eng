<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $category core\entities\Category\Category */
/* @var $model \core\forms\manage\Category\IconForm */


//var_dump($model);die;

$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];
\yii\web\YiiAsset::register($this);
?>
<div class="category-icon">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>
    <div class="post-form-image" style="margin-top: 28px">
        <? if ($category): ?>
            <img src="<?= $category->getIconPath() ?>" class="img-responsive">
        <? endif; ?>
    </div>
    <?= $form->field($model, 'icon')->fileInput(['options' => ['accept' => 'image/*']]) ?>
    <div style="margin-top: 40px">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


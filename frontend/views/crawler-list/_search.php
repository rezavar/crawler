<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\CrawlerListSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="crawler-list-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IdCrawlerList') ?>

    <?= $form->field($model, 'Name') ?>

    <?= $form->field($model, 'Url') ?>

    <?= $form->field($model, 'CreateDate') ?>

    <?= $form->field($model, 'UpdateDate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

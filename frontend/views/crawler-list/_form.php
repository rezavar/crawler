<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;


/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var common\models\CrawlerList $model */

?>

<div class="crawler-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Name')->textInput(['maxlength' => true,'autofocus' => true]) ?>

    <?= $form->field($model, 'Url')->textInput(['maxlength' => true,'style'=>'direction:ltr']) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

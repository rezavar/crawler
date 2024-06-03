<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;


/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var common\models\CrawlerList $model */

?>

<div class="crawler-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Name')->textInput(['maxlength' => true, 'autofocus' => true]) ?>

    <?= $form->field($model, 'Url')->textInput(['maxlength' => true, 'style' => 'direction:ltr']) ?>

    <?php
    if (isset($formType) && $formType == 'update' )
        echo $form->field($model, 'Status')->dropDownList($model::Status_Arr());
    ?>


        <?= $form->field($model, 'FileCategory')->fileInput() ?>

        <?= $form->field($model, 'FileProductList')->fileInput() ?>

        <?= $form->field($model, 'FileProductDetails')->fileInput() ?>


        <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success']) ?>


    <?php ActiveForm::end(); ?>

</div>

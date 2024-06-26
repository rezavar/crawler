<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CrawlerList $model */

$this->title = 'بروز رسانی خرنده: ' . $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'لیست خزنده‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Name, 'url' => ['view', 'CrawlerListId' => $model->CrawlerListId]];
$this->params['breadcrumbs'][] = 'ویرایش';

var_export($model->errors)
?>
<div class="crawler-list-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model, 'formType'=>'update'
    ]) ?>

</div>

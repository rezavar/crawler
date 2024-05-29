<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CrawlerList $model */

$this->title = 'بروز رسانی خرنده: ' . $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'لیست خزنده‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Name, 'url' => ['view', 'IdCrawlerList' => $model->IdCrawlerList]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<div class="crawler-list-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

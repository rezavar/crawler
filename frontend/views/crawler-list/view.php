<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\CrawlerList $model */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'لیست خزنده‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
    #view_crawler_by_id tr td:last-child{
        direction: ltr;
    }
</style>
<div class="crawler-list-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('ویرایش', ['update', 'IdCrawlerList' => $model->IdCrawlerList], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('حذف', ['delete', 'IdCrawlerList' => $model->IdCrawlerList], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'id'=>'view_crawler_by_id',
        'attributes' => [
            'IdCrawlerList',
            'Url:url',
            'CreateDate',
            [
                'attribute' =>'UpdateDate',
                'value' => function ($model) {
                    return $model->UpdateDate ? $model->UpdateDate: 'بدون بروز رسانی';
                }
            ],
        ],
    ]) ?>

</div>

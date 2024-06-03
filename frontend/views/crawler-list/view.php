<?php

use common\models\CrawlerList;
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
        <?= Html::a('ویرایش', ['update', 'CrawlerListId' => $model->CrawlerListId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('حذف', ['delete', 'CrawlerListId' => $model->CrawlerListId], [
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
            'CrawlerListId',
            'Url:url',
            'CreateDate',
            [
                'attribute' =>'Status',
                'value' => function ($model) {
                    return CrawlerList::Status_str($model->Status);
                }
            ]
        ],
    ]) ?>

</div>

<?php

use common\models\CrawlerList;
use kartik\icons\FontAwesomeAsset;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

FontAwesomeAsset::register($this);


$this->title = 'دسته بندی‌ها';
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    .operation{
        display: flex;
        justify-content: space-around;
    }
</style>
<div class="categories-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('بروز رسانی دسته ها', ['update-all'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'Name',
            'Url:url',
            'CreateDate',
            [
                'class' => ActionColumn::class,
                'template' => '{update} {update-category}',
                'urlCreator' => function ($action, CrawlerList $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'CrawlerListId' => $model->CrawlerListId]);
                },
                'contentOptions'=>['class'=>'operation'],
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-retweet text-warning"></i>', $url, [
                            'title' => 'بروز رسانی دسته ها',
                            'onclick'=>"return confirm('برای بروز رسانی دسته ها مطمین هستید?')"
                        ]);
                    },
                    'update-category'=>function ($url, $model) {
                        return Html::a('<i class="fas fa-eye text-success"></i>', $url, [
                            'title' => 'بروز رسانی دسته ها',
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>

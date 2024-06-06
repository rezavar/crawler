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
                'template' => '{update-category} {view}',
                'urlCreator' => function ($action, CrawlerList $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'CrawlerListId' => $model->CrawlerListId]);
                },
                'buttons' => [
                    'update-category' => function ($url, $model) {
                        return Html::a('<i class="fas fa-retweet text-success"></i>', $url, [
                            'title' => 'بروز رسانی دسته ها',
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>

<?php

use common\models\CrawlerList;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\CrawlerListSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'لیست خزنده‌ها';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crawler-list-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('ایجاد یک خزنده', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'IdCrawlerList',
            'Name',
            'Url:url',
            'CreateDate',
            'UpdateDate',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CrawlerList $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'IdCrawlerList' => $model->IdCrawlerList]);
                 }
            ],
        ],
    ]); ?>


</div>

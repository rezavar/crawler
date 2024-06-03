<?php

use common\models\CrawlerList;
use kartik\icons\FontAwesomeAsset;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

//use kartik\icons\Icon;
FontAwesomeAsset::register($this);
//Icon::map($this, Icon::FAS);

/** @var yii\web\View $this */
/** @var \frontend\models\crawlerList\CrawlerListSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'لیست خزنده‌ها';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="crawler-list-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('ایجاد یک خزنده', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<!--    --><?php //echo Icon::show('eye', [ 'framework' => Icon::FA]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'CrawlerListId',
            'Name',
            'Url:url',
            'CreateDate',
            [
                'attribute' =>'Status',
                'filter'=>CrawlerList::Status_Arr(),
                'value' => function ($model) {
                    return CrawlerList::Status_str($model->Status);
                }
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{update} {view}',
                'urlCreator' => function ($action, CrawlerList $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'CrawlerListId' => $model->CrawlerListId]);
                 }
            ]
        ],
    ]); ?>


</div>

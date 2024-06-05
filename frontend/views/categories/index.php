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


</div>

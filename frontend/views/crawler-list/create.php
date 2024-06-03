<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CrawlerList $model */

$this->title = 'تعریف یک خزنده';
$this->params['breadcrumbs'][] = ['label' => 'لیست خزنده‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
if(isset($export))
    echo $export;
?>
<div class="crawler-list-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model, 'formType'=>'create'
    ]) ?>

</div>



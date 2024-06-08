<?php


use common\models\Category;
use frontend\models\categories\TreeView;
use kartik\icons\FontAwesomeAsset;
use yii\helpers\Html;use yii\helpers\Url;

FontAwesomeAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => 'دسته بندی‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'ویرایش';

?>
<style xmlns="http://www.w3.org/1999/html">
    .fa-check-circle{
        color:var(--bs-success)!important;
    }
    .fa-plus-circle{
        color:var(--bs-info)!important;
    }
    .fa-minus-circle{
        color:var(--bs-danger)!important;
    }
    .link-status {

    }
</style>

<div >
    <div class="mb-3">
     <?= Html::a('همه',
            Url::to(['update-category','CrawlerListId'=>$CrawlerListId]),
            ['class'=>'btn btn-light'.(is_null($Status)?' disabled':'')])?>

     <?= Html::a('جدید',
         Url::to(['update-category','CrawlerListId'=>$CrawlerListId,'Status'=> Category::NewRecord]),
         ['class'=>'btn btn-info'.(!is_null($Status)&&$Status==Category::NewRecord?' disabled':'')])?>
     <?= Html::a('حذف شده',
         Url::to(['update-category','CrawlerListId'=>$CrawlerListId,'Status'=>Category::DeleteRecord]),
         ['class'=>'btn btn-danger mx-3'.($Status==Category::DeleteRecord?' disabled':'')])?>
     <?= Html::a('ثبت شده',
         Url::to(['update-category','CrawlerListId'=>$CrawlerListId,'Status'=>Category::AcceptRecord]),
         ['class'=>'btn btn-success'.($Status==Category::AcceptRecord?' disabled':'')])?>

    </div>
    <div style="direction: ltr">

    <?php
        $header = '';
         if(is_null($Status))
             $header =  "نمایش همه";
        elseif($Status==Category::NewRecord)
            $header =  "نمایش دسته های جدید";
         elseif($Status==Category::DeleteRecord)
             $header =  "نمایش دسته های حذف شده";
         elseif($Status==Category::AcceptRecord)
             $header =  "نمایش دسته های تایید شده";
        ?>
    </span>
    <?= TreeView::widget([
        'query' => $newTreeQuery,
        'displayValue'=>$displayValue,
        'isAdmin' => false,
        'id'=>'treeID',
        'mainTemplate'=><<< HTML
<div class="row">
    <div class="col-sm-4">
        {wrapper}
    </div>
    <div class="col-sm-8">
        {detail}
    </div>
</div>
HTML,
        'wrapperTemplate' => "<div style='text-align: center; margin: .5rem'><b>$header</b></div>{tree}",
        'hideTopRoot' => true,
        'softDelete' => true,
        'fontAwesome' => true,
        'cacheSettings' => ['enableCache' => true],
        'nodeView' => '@frontend/views/categories/_form.php'
        ]);

    ?>
    </div>
</div>
<?php
$script = <<<JS

     $(document).ready(()=>{

         console.log($('#treeID').treeview())
         
    
    });
JS;
$this->registerJs($script);
?>

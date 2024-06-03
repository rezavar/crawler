<?php
use kartik\tree\TreeView;
use common\models\TreeMaker;
use kartik\icons\FontAwesomeAsset;
use kartik\tree\TreeViewInput;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

FontAwesomeAsset::register($this);

/** @var yii\web\View $this */
$model = new \frontend\models\crawlers\Caregory();
$this->title = 'صفحه اصلی';
?>
<div class="site-index">
   آمار کلی خزنده
    <?=\Yii::$app->PDate->asDatetime('now')?>
    <a href="<?= \yii\helpers\Url::to(['crawler-list/test']) ?>">test</a>

    <hr/>
    <br/>

    <div class="clearfix"></div>
    <div style="direction: ltr">
        <?php $form = ActiveForm::begin(); ?>

<?=$form->field($model, 'category_list')->widget(TreeViewInput::classname(),
            [
                'name' => 'category_list',
                'value' => 'true', // preselected values
                'query' => TreeMaker::find()->addOrderBy('root, lft'),
                'headingOptions' => ['label' => 'دسته بندی ها'],
                'rootOptions' => ['label'=>''],
                'fontAwesome' => false,
                'asDropdown' => false,
                'multiple' => true,
                'options' => ['disabled' => false]
            ]);

?>
        <div class="form-group mt-3">
            <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>



        <?php

//        \kartik\tree\TreeViewInput::widget([
//            'name' => 'kvTreeInput',
//            'value' => 'true', // preselected values
//            'query' => TreeMaker::find()->addOrderBy('root, lft'),
//            'headingOptions' => ['label' => ''],
//            'rootOptions' => ['label'=>'<i class="fas fa-tree text-success"></i>'],
//            'fontAwesome' => false,
//            'asDropdown' => false,
//            'multiple' => true,
//            'options' => ['disabled' => false]
//        ]);


        //\kartik\tree\TreeView::widget([
        //    'query' => TreeMaker::find()->addOrderBy('root, lft'),
        //    'headingOptions' => ['label' => ''],
        //    'rootOptions' => ['label'=>'<span class="text-primary"></span>'],
        //    'topRootAsHeading' => true, // this will override the headingOptions
        //    'fontAwesome' => true,
        //    'isAdmin' => true,
        //    'iconEditSettings'=> [
        //        'show' => 'list',
        //        'listData' => [
        //            'folder' => 'Folder',
        //            'file' => 'File',
        //        ]
        //    ],
        //    'softDelete' => true,
        //    'cacheSettings' => ['enableCache' => true]
        //]);
        ?>

    </div>
</div>

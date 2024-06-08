<?php

use common\models\Category;
use kartik\form\ActiveForm;
use kartik\tree\models\Tree;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Tree $node
 * @var ActiveForm $form
 * @var mixed $currUrl
 * @var array $params
 *
 */
?>


<?php

extract($params);
$name = $node->getBreadcrumbs(
    ArrayHelper::getValue($breadcrumbs, 'depth', '') ,
    ArrayHelper::getValue($breadcrumbs, 'glue', ''),
    ArrayHelper::getValue($breadcrumbs, 'activeCss', ''),
    ArrayHelper::getValue($breadcrumbs, 'untitled', '')
);

$form = ActiveForm::begin(['method' => 'post','action'=>$currUrl, 'options' => $formOptions]);



    ?>
    <div class="kv-detail-heading d-flex justify-content-between" style="direction: rtl;">
        <div class="kv-detail-crumbs " ><?= $name." (".$node->CategoryId.")" ?></div>
        <div class="">
            <?php
            if($node->isLeaf() && $node->Status != Category::DeleteRecord)
                echo Html::submitButton('<i class="fas fa-save"></i>',
                    ['class' => 'btn btn-sm btn-primary', 'title' => 'ذخیره']
                );
            ?>
        </div>
    </div>
    <div class="clearfix"></div>
<?php
echo Html::hiddenInput('treeManageHash', $treeManageHash);
echo $form->field($node, 'CategoryId')->hiddenInput()->label(false);
if($node->isLeaf() ):
$option= [];
if($node->Status == Category::DeleteRecord)
    $option=['readOnly'=>true]
?>
    <div class="row" style="direction: rtl">
        <div >
            <?= $form->field($node, 'selected')->checkbox(['custom' => true]) ?>
        </div>
        <div >
            <?= $form->field($node, 'OurName')->textInput($option) ?>
        </div>
        <div >
            <?= $form->field($node, 'OurCategoryId')->textInput($option) ?>
        </div>
    </div>


<?php endif; ?>

<?php ActiveForm::end(); ?>





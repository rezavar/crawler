<?php

use kartik\tree\TreeView;
use kartik\icons\FontAwesomeAsset;

FontAwesomeAsset::register($this);


?>

<div >
    <div >

    </div>
    <?= TreeView::widget([
        'query' => $newTreeQuery,
        'isAdmin' => false,
        'wrapperTemplate' => "{tree}",
        'mainTemplate' => '<div style="direction: ltr">{wrapper}</div>',
        'hideTopRoot' => true,
        'softDelete' => true,
        'cacheSettings' => ['enableCache' => true]
    ]);

    ?>
</div>

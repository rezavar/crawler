<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\ContactForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'تماس با ما';

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        کانال های ارتباطی ما
    </p>

    <div class="row">
        <div class="col-lg-5">
            شماره تماس :
            <br/>
            ایمیل :
        </div>
    </div>

</div>

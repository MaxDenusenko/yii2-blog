<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\SignupForm */

$this->title = 'Sign Up';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="main">
    <div class="post">
        <section>
            <h3><?=Yii::t('app', 'Sign Up')?></h3>
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'class' => "form-horizontal"]); ?>
            <div class="row uniform">
                <div class="12u 12u$(xsmall)">
                    <?= $form->field($model, 'username')->textInput(['placeholder' => Yii::t('app', 'Name')])->label(false) ?>
                </div>
                <div class="12u 12u$(xsmall)">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('app', 'Email')])->label(false) ?>
                </div>
                <div class="12u$ 12u$(xsmall)">
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Password')])->label(false) ?>
                </div>
                <div class="12u$ 12u$(xsmall)">
                    <?= $form->field($model, 'rpPassword')->passwordInput(['placeholder' => Yii::t('app', 'Confirm Password')])->label(false) ?>
                </div>
                <div class="12u$ 12u$(xsmall)">
                    <?= $form->field($model, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false) ?>
                </div>
                <div class="12u$">
                    <ul class="actions">
                        <li><input type="submit" value="<?=Yii::t('app', 'Sign Up')?>"></li>
                    </ul>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </section>
    </div>
</div>

<!-- Sidebar -->
<?php try {
    echo \app\widgets\LSidebar::widget();
} catch (Exception $e) {
} ?>

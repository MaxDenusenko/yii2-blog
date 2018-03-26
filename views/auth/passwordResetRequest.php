<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\PasswordResetRequestForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="main">
    <div class="post">
        <section>
            <h3><?=Yii::t('app', 'Please enter your email')?></h3>
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form',]); ?>
            <div class="row uniform">
                <div class="12u 12u$(xsmall)">
                    <?= $form->field($model, 'email')->textInput()->label(false) ?>
                </div>
                <div class="12u$">
                    <ul class="actions">
                        <li><input type="submit" value="<?=Yii::t('app', 'Send')?>"></li>
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


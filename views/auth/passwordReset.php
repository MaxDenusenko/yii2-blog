<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\ResetPasswordForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="main">
    <div class="post">
        <section>
            <h3><?=Yii::t('app', 'Enter a new password')?></h3>
            <?php $form = ActiveForm::begin(['id' => 'request-password-form',]); ?>
            <div class="row uniform">
                <div class="12u 12u$(xsmall)">
                    <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
                </div>
                <div class="12u$">
                    <ul class="actions">
                        <li><input type="submit" value="<?=Yii::t('app', 'Save')?>"></li>
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
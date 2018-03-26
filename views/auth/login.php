<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="main">
    <div class="post">
        <section>
            <h3><?=Yii::t('app', 'Log In')?></h3>
            <?php $form = ActiveForm::begin(['id' => 'login-form',]); ?>
                <div class="row uniform">
                    <div class="12u 12u$(xsmall)">
                        <?= $form->field($model, 'username')->textInput(['placeholder' => Yii::t('app', 'Name')])->label(false) ?>
                    </div>
                    <div class="12u$ 12u$(xsmall)">
                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Password')])->label(false) ?>
                    </div>
                    <div class="12u$ 12u$(xsmall)">
                        <?= $form->field($model, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false) ?>
                    </div>
                    <?php $checkboxTemplate = '{input}<label for="demo-human">Remember me</label>{error}'; ?>
                    <div class="6u$ 12u$(small)">
                        <?= $form->field($model, 'rememberMe')->checkbox([
                                'id' => 'demo-human',
                            'name' => 'demo-human',
                            'template' =>  $checkboxTemplate
                        ])->label(false) ?>
                    </div>
                    <div class="12u$">
                        <ul class="actions">
                            <li><input type="submit" value="<?=Yii::t('app', 'Log In')?>"></li>
                        </ul>
                    </div>
                    <div class="6u$ 12u$(small)">
                        <?=Yii::t('app', 'If you forgot your password, you can ')?><?= Html::a(Yii::t('app', 'change it'), ['auth/password-reset-request']) ?>.
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


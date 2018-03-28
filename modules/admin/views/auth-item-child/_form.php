<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItemChild */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-child-form">
    <p>The parent receives all rights from his child</p>
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">
        <?= $form->field($model, 'parent')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\app\models\AuthItem::find()->all(), 'name', 'name'),
            'language' => 'en',
            'options' => [
                'placeholder' => 'Select role or permission ...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'child')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\app\models\AuthItem::find()->all(), 'name', 'name'),
            'language' => 'en',
            'options' => [
                'placeholder' => 'Select role or permission ...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]) ?>
    </div>
    <div class="form-group col-md-12">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

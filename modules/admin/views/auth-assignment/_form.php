<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12">
        <?= $form->field($model, 'item_name')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\app\models\AuthItem::find()->where(['type' => 1])->all(), 'name', 'name'),
            'language' => 'en',
            'options' => [
                'placeholder' => 'Select role ...',
//                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]) ?>
    </div>
    <div class="col-md-12">
    <?= $form->field($model, 'user_id')->widget(\kartik\select2\Select2::className(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->where(['status' => 1])->all(), 'id', 'username'),
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select user ...',
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

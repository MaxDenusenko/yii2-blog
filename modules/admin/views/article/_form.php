<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<?php try {
    echo \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]);
} catch (Exception $e) {
} ?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(\app\models\Category::find()->select(['title', 'id'])->indexBy('id')->column(), ['prompt' => '']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tags_array')->widget(\kartik\select2\Select2::className(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Tag::find()->all(), 'id', 'title'),
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select tag ...',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
            'maximumInputLength' => 10
        ],
    ]) ?>

    <?= $form->field($model, 'description')->widget(\vova07\imperavi\Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 80,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]);?>

    <?= $form->field($model, 'content')->widget(\vova07\imperavi\Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 180,
            'imageUpload' => \yii\helpers\Url::to(['/admin/default/save-redactor-img', 'sub' => 'redactor-article']),
            'fileUpload' => \yii\helpers\Url::to(['/admin/default/save-redactor-file', 'sub' => 'redactor-article']),
            'plugins' => [
                'clips',
                'fullscreen',
                'imagemanager',
                'filemanager',
            ],
        ],
    ]);?>

    <?=$form->field($model, 'imageFile')->widget(\kartik\file\FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'browseLabel' =>  'Select Photo',
            'initialPreview'=>[
                $model->image ? Html::img("/resources/img/article/" . $model->image, ['height' => '100%', 'width' => '100%']) : null
            ],
        ],
    ]);?>

    <?= $form->field($model, 'status')->dropDownList(\app\models\Article::getStatusesArray(), ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

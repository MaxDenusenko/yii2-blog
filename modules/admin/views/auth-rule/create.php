<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AuthRule */

$this->title = Yii::t('app', 'Create Rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rbac'), 'url' => ['/admin/rbac']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-rule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php try {
        echo \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]);
    } catch (Exception $e) {
    } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

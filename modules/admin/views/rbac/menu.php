<?php
/** @var \yii\web\View $this */

use yii\helpers\Url;
?>

<div class="bs-example col-md-12" data-example-id="simple-justified-button-group">
    <a href="<?=Url::to(['/admin/auth-item', 'AuthItemSearch' => ['type' => 1]])?>" class="btn btn-dark" role="button"><?=Yii::t('app', 'Role')?></a>
    <a href="<?=Url::to(['/admin/auth-item', 'AuthItemSearch' => ['type' => 2]])?>" class="btn btn-dark" role="button"><?=Yii::t('app','Permission')?></a>
    <a href="<?=Url::to(['/admin/auth-item-child'])?>" class="btn btn-dark" role="button"><?=Yii::t('app', 'Inheritance')?></a>
    <a href="<?=Url::to(['/admin/auth-assignment'])?>" class="btn btn-dark" role="button"><?=Yii::t('app', 'Assignment')?></a>
    <a href="<?=Url::to(['/admin/auth-rule'])?>" class="btn btn-dark" role="button"><?=Yii::t('app', 'Rule')?></a>
</div>

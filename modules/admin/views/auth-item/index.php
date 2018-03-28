<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rbac'), 'url' => ['/admin/rbac']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/rbac/menu');?>

<div class="auth-item-index col-md-12">
    <hr>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Role'), ['create', 'type'=> 1], ['class' => 'btn btn-default']) ?>
        <?= Html::a(Yii::t('app', 'Create Permission'), ['create', 'type'=> 2], ['class' => 'btn btn-default']) ?>
    </p>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [

                'name',
                'type',
                'rule_name',
                'description:ntext',
                'data',
                //'created_at',
                //'updated_at',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                ],
            ],
        ]);
    } catch (Exception $e) {}
    ?>
    <?php Pjax::end(); ?>
</div>

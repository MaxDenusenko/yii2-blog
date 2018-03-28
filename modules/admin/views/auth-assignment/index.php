<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AuthAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Assignments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rbac'), 'url' => ['/admin/rbac']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/rbac/menu');?>

<div class="auth-assignment-index col-md-12">

    <hr>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Assignment'), ['create'], ['class' => 'btn btn-default']) ?>
    </p>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [

                'item_name',
                'user_id',
                'created_at',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                ],
            ],
        ]);
    } catch (Exception $e) {
    } ?>
    <?php Pjax::end(); ?>
</div>

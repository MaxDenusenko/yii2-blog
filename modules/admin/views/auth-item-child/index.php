<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AuthItemChildSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Inheritance');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rbac'), 'url' => ['/admin/rbac']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/rbac/menu');?>

<div class="auth-item-child-index col-md-12">

    <hr>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Inheritance'), ['create'], ['class' => 'btn btn-default']) ?>
    </p>

    <?php try {
        echo \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]);
    } catch (Exception $e) {
    } ?>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [

                'parent',
                'child',

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

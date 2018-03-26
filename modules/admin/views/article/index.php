<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php try {
        echo \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]);
    } catch (Exception $e) {
    } ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Article'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],

                //'id',
                'title',
                [
                    'attribute' => 'category_id',
                    'filter' => \app\models\Category::find()->select(['title', 'id'])->indexBy('id')->column(),
                    'value' => 'category.title'
                ],
                [
                    'attribute' => 'created_at',
                    'value' => 'created_at',
                    'filter' => \dosamigos\datepicker\DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'template' => '{addon}{input}',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-m-d'
                        ],
                    ]),
                    'format' => 'date',
                ],
                //'updated_at',
                [
                    'attribute' => 'publisher_at',
                    'value' => 'publisher_at',
                    'filter' => \dosamigos\datepicker\DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'publisher_at',
                        'template' => '{addon}{input}',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-m-d'
                        ],
                    ]),
                    'format' => 'date',
                ],
                //'description:ntext',
                //'content:ntext',
                [
                    'attribute' => 'image',
                    'value' => function ($model) {
                        if ($model->fullImage)
                            return Html::img($model->fullImage, ['width'=>'100']);
                        return null;
                    },
                    'format' => 'html',
                    'filter' => false,
                ],
                //'viewed',
                //'user_id',
                //'status',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    } catch (Exception $e) {
    } ?>
    <?php Pjax::end(); ?>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php try {
    echo \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]);
} catch (Exception $e) {
} ?>

<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php try {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'created_at',
                'updated_at',
                'publisher_at',
                'title',
                'description:html',
//                'content:html',
                [
                    'attribute' => 'image',
                    'value' => function ($model) {
                        if ($model->fullImage)
                            return Html::img($model->fullImage, ['width'=>'100']);
                        return null;
                    },
                    'format' => 'html',
                ],
                'viewed',
                'user_id',
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        $arr = \app\models\Article::getStatusesArray();
                        return $arr[$model->status];
                    },
                ],
                [
                    'attribute' =>  'category_id',
                    'value' =>  \yii\helpers\ArrayHelper::getValue($model, 'category.title'),
                ],
            ],
        ]);
    } catch (Exception $e) {
    } ?>

</div>

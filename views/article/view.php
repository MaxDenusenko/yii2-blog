<?php
/** @var \app\models\Article $model */

$this->title = $model->title;
?>

<div id="main">
    <!-- Post -->
    <article class="post">
        <header>
            <div class="title">
                <h2>
                    <?=$model->title?>
                </h2>
                <p><?=$model->category->title?></p>
            </div>
            <div class="meta">
                <time class="published" datetime="<?=Date('F j, Y',strtotime($model->publisher_at))?>"><?=Date('F j, Y',strtotime($model->publisher_at))?></time>
                <a href="#" class="author">
                    <span class="name"><?= isset($model->user->username) ? $model->user->username : '' ?></span>
                    <img src="images/avatar.jpg" alt="" />
                </a>
            </div>
        </header>
        <p><?=$model->content?></p>
        <footer>
            <ul class="icons actions">
                <li><a href="#" class="fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="#" class="fa-facebook"><span class="label">Facebook</span></a></li>
                <li><a href="#" class="fa-instagram"><span class="label">Instagram</span></a></li>
                <li><a href="#" class="fa-rss"><span class="label">RSS</span></a></li>
                <li><a href="#" class="fa-envelope"><span class="label">Email</span></a></li>
            </ul>
            <ul class="stats">
                <li><a href="#">General</a></li>
                <li><a class="icon fa-eye"><?=count($model->viewsArticles)?></a></li>
                <li>
                    <?php \yii\widgets\Pjax::begin([
                        'enablePushState' => false,
                    ]); ?>
                    <a href="<?=\yii\helpers\Url::to(['/article/like', 'id' => $model->id])?>" class="icon fa-heart"><?=count($model->likeArticles)?></a>
                    <?php \yii\widgets\Pjax::end(); ?>
                </li>
                <li><a href="#" class="icon fa-comment">128</a></li>
            </ul>
        </footer>
    </article>

    <div id="article-comment">
        <?php
        try {
            echo \yii2mod\comments\widgets\Comment::widget([
                'model' => $model,
//                'commentView' => '@app/views/site/comments/index', // path to your template
                'relatedTo' => 'User ' . \Yii::$app->user->identity->username . ' commented on the page ' . \yii\helpers\Url::current(),
                'maxLevel' => 2,
                'dataProviderConfig' => [
                    'pagination' => [
                        'pageSize' => 10
                    ],
                ],
                'listViewConfig' => [
                    'emptyText' => \Yii::t('app', 'No comments found.'),
                ],
            ]);
        } catch (Exception $e) {}
        ?>
    </div>
</div>

<!-- Sidebar -->
<?php try {
    echo \app\widgets\LSidebar::widget();
} catch (Exception $e) {
} ?>

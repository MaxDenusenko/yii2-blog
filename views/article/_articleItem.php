<?php
/** @var \app\models\Article $model */
?>
<!-- Post -->
<article class="post">
    <header>
        <div class="title">
            <h2>
                <a href="<?=\yii\helpers\Url::to(['/article/view', 'id' => $model->id])?>"><?=$model->title?></a>
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
    <?php if ($model->image) :?>
        <a href="<?=\yii\helpers\Url::to(['/article/view', 'id' => $model->id])?>" class="image featured"><img src="<?=$model->getFullImage()?>" alt="" /></a>
    <?php endif; ?>
    <p><?=$model->description?></p>
    <footer>
        <ul class="actions">
            <li><a href="<?=\yii\helpers\Url::to(['/article/view', 'id' => $model->id])?>" class="button big">Continue Reading</a></li>
        </ul>
        <ul class="stats">
            <li><a href="#">General</a></li>
            <li><a href="#" class="icon fa-heart">28</a></li>
            <li><a href="#" class="icon fa-comment">128</a></li>
        </ul>
    </footer>
</article>

<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrapper">

    <!-- Header -->
    <header id="header">
        <h1><a href="#">Future Imperfect</a></h1>
        <nav class="links">
            <?php
            try {
                echo Nav::widget([
                    'options' => ['class' => ''],
                    'items' => [
                        ['label' => 'Home', 'url' => ['/site/index']],
                        ['label' => 'About', 'url' => ['/site/about']],
                        ['label' => 'Contact', 'url' => ['/site/contact']],
                    ],
                ]);
            } catch (Exception $e) {
            }
            ?>
        </nav>
        <nav class="main">
            <ul>
                <?php if (!Yii::$app->user->isGuest) : ?>
                    <li class="menu">
                        <a title="<?php if (isset(Yii::$app->user->identity->username)) echo Yii::$app->user->identity->username; else ''?>" href="#" class="fa-user">
                            <?php if (isset(Yii::$app->user->identity->username)) echo Yii::$app->user->identity->username; else ''?>
                        </a>
                    </li>
                <?php endif;?>
                <li class="search">
                    <a title="Search" class="fa-search" href="#search">Search</a>
                    <form id="search" method="get" action="#">
                        <input type="text" name="query" placeholder="Search" />
                    </form>
                </li>
                <li title="Menu" class="menu">
                    <a class="fa-bars" href="#menu">Menu</a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Menu -->
    <section id="menu">

        <!-- Search -->
        <section>
            <form class="search" method="get" action="#">
                <input type="text" name="query" placeholder="Search" />
            </form>
        </section>

        <!-- Links -->
        <section>
            <ul class="links">
                <li>
                    <a href="#">
                        <h3>Lorem ipsum</h3>
                        <p>Feugiat tempus veroeros dolor</p>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <h3>Dolor sit amet</h3>
                        <p>Sed vitae justo condimentum</p>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <h3>Feugiat veroeros</h3>
                        <p>Phasellus sed ultricies mi congue</p>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <h3>Etiam sed consequat</h3>
                        <p>Porta lectus amet ultricies</p>
                    </a>
                </li>
            </ul>
        </section>

        <!-- Actions -->
        <section>
            <ul class="actions vertical">
                <?php if (Yii::$app->user->isGuest) : ?>
                <li><a href="<?=\yii\helpers\Url::to(['/auth/login'])?>" class="button big fit">Log In</a></li>
                <li><a href="<?=\yii\helpers\Url::to(['/auth/signup'])?>" class="button big fit">Sign Up</a></li>
                <?php else: ?>
                <li><a href="<?=\yii\helpers\Url::to(['/auth/logout'])?>" class="button big fit">Log Out</a></li>
                <?php endif; ?>
            </ul>
        </section>

    </section>

    <!-- Main -->
    <?=$content?>

</div>

<?php
    try {
        echo \yii2mod\alert\Alert::widget();
    } catch (Exception $e) {}
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

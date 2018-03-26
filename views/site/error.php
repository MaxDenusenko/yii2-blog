<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div id="main">
    <div class="post text-center">
        <div class="text-center d-flex justify-content-center">
            <div class="site-error mt-5 white_body">
                <div class="col-middle">
                    <div class="text-center text-center">
                        <h1 class="error-number"><?= Html::encode($this->title) ?></h1>
                        <h2><?= nl2br(Html::encode($message)) ?></h2>
                        <p>
                            <?=Yii::t('app', 'The above error occurred while the Web server was processing your request')?>
                        </p>
                        <p>
                            <?=Yii::t('app', 'Please contact us if you think this is a server error. Thank you.')?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sidebar -->
<?php try {
    echo \app\widgets\LSidebar::widget();
} catch (Exception $e) {
} ?>

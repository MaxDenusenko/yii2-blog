<?php

/* @var \yii\data\ActiveDataProvider $dataProvider */
/* @var \app\models\search\ArticleFrontSearch $searchModel */
?>
<div id="main">
    <?php if ($dataProvider) : ?>
        <?php try {
            echo \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => '_articleItem',
//        'viewParams' => ['form' => $form, 'searchModel' => $searchModel],
                'emptyText' => false,
                'layout' => "{items}\n{pager}",
                'pager' => [
                    'options' => ['class' => 'actions pagination'],

                    'firstPageLabel' => false,
                    'lastPageLabel'  => false,
                    'prevPageLabel'  => 'PREVIOUS PAGE',
                    'nextPageLabel'  => 'NEXT PAGE',
                    'maxButtonCount' => 0,

                    // Customzing CSS class for pager link
                    'linkOptions' => ['class' => 'button big'],
                    'activePageCssClass' => 'active',
                    'disabledPageCssClass' => 'disabled',

                    // Customzing CSS class for navigating link
                    'prevPageCssClass' => 'previous',
                    'nextPageCssClass' => 'next',
                    'firstPageCssClass' => '',
                    'lastPageCssClass' => '',
                ],
            ]);
        } catch (Exception $e) {
        } ?>
    <?php endif; ?>
</div>

<!-- Sidebar -->
<?php try {
    echo \app\widgets\LSidebar::widget();
} catch (Exception $e) {
} ?>


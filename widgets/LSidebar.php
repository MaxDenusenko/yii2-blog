<?php
namespace app\widgets;

use yii\base\Widget;

class LSidebar extends Widget
{
    public function init()
    {
        parent::init();
    }

    /**
     * Generating html for right sidebar
     * @return string
     */
    public function run()
    {
        return $this->renderFile(\Yii::getAlias('@app').'/views/widgets/leftSidebar.php', [

        ]);
    }
}

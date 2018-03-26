<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site/main.css',
        'css/site/ie8.css',
        'css/site/ie9.css',
    ];
    public $js = [
        'js/site/html5shiv.js',
//        'js/site/jquery.min.js',
        'js/site/skel.min.js',
        'js/site/util.js',
        'js/site/respond.min.js',
        'js/site/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

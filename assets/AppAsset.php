<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
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
    public $baseUrl = '@web/web';
    public $css = [
        'css/site.css',
        'sass/vender/bootstrap.css',
        'sass/main.css',
        'owlcarousel/owl.carousel.min.css',
        'sass/vender/bootstrap.min.css',
    ];
    public $js = [
        'js/main.js',
        'js/carousel.js',
        'owlcarousel/owl.carousel.min.js',
        'owlcarousel/jquery.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',

    ];
}
